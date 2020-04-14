<?php

namespace App\Services\Amo;

use App\Entity\Amo\AmoData;
use App\Entity\Amo\AmoStatus;
use App\Entity\Amo\AmoUtm;
use App\Exception\NoCustomFieldsException;
use DateTime;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class HookRegisterService
 * @package App\Services\Amo
 */
class FieldsConverter
{
    /**
     * @var StatusService
     */
    private $statusService;

    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    /**
     * FieldsConverter constructor.
     * @param StatusService $statusService
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(StatusService $statusService, ParameterBagInterface $parameterBag)
    {
        $this->statusService = $statusService;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param array $fields
     * @return AmoData
     * @throws Exception
     * @throws NoCustomFieldsException
     */
    public function convert(array $fields): AmoData
    {
        $id = $this->get('id', $fields);
        $price = $this->get('price', $fields);

        $status = $this->statusService->create($this->get('status_id', $fields));
        $oldStatus = $this->statusService->create($this->get('old_status_id', $fields, 0));

        $createTime = new DateTime('@' . $this->get('date_create', $fields));
        $updateTime = new DateTime('@' . $this->get('last_modified', $fields));
        $sendTime = new DateTime();

        $utm = $this->getUtm($fields);

        return new AmoData($id, $status, $oldStatus, $createTime, $updateTime, $sendTime, $price, $utm);
    }

    /**
     * @param string $name
     * @param array $array
     * @param string $default
     * @return string
     */
    private function get(string $name, array $array, $default = ''): string
    {
        return !empty($array[$name]) ? $array[$name] : $default;
    }

    /**
     * @param array $fields
     * @return AmoUtm
     * @throws NoCustomFieldsException
     */
    private function getUtm(array $fields): AmoUtm
    {
        if (isset($fields['custom_fields'])) {
            $utmFields = $this->parseCustomFields($fields['custom_fields']);

            return new AmoUtm(
                $this->get($this->parameterBag->get('amo.utm.source'), $utmFields),
                $this->get($this->parameterBag->get('amo.utm.medium'), $utmFields),
                $this->get($this->parameterBag->get('amo.utm.campaign'), $utmFields),
                $this->get($this->parameterBag->get('amo.utm.content'), $utmFields),
                $this->get($this->parameterBag->get('amo.utm.term'), $utmFields),
                $this->get($this->parameterBag->get('amo.client_id'), $utmFields)
            );
        }

        throw new NoCustomFieldsException();
    }

    /**
     * Convert custom_fields array to assoc array
     * "custom_fields" => ["id" => "105335", "name" => "utm_source", "values" => ["value" => "google"]]
     *
     * @param array $customFields
     * @return array
     */
    private function parseCustomFields(array $customFields): array
    {
        $array = [];

        foreach ($customFields as $field) {
            $name = $this->get('id', $field);
            $value = isset($field['values'][0]['value']) ? $field['values'][0]['value'] : '';

            $array[$name] = $value;
        }

        return $array;
    }
}
