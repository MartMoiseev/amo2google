<?php

namespace App\Controller;

use App\Entity\Google\BasicAnalytics;
use App\Entity\Google\CampaignAnalytics;
use App\Entity\Google\EventAnalytics;
use App\Entity\HookLog;
use App\Services\Amo\HookRegisterService;
use App\Services\Google\AnalyticsFacade;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AmoController
 * @package App\Controller
 */
class AmoController extends AbstractController
{
    /**
     * @Route("/register", name="amo-register")
     *
     * @param HookRegisterService $registerService
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     * @throws Exception
     */
    public function register(HookRegisterService $registerService, Request $request, EntityManagerInterface $manager)
    {
        $rawData = json_encode($request->request->all());

        $hookLog = new HookLog();
        $hookLog->setBody($rawData);
        $manager->persist($hookLog);
        $manager->flush();

        $registerService->register($rawData, new DateTime());

        return new JsonResponse(['ok']);
    }

    /**
     * @Route("/test", name="amo-test")
     *
     * @param HookRegisterService $registerService
     * @return JsonResponse
     * @throws Exception
     */
    public function test(HookRegisterService $registerService)
    {
        $request = '{"leads":{"update":[{"id":"1473787","name":"\u041a\u0443\u043f\u0438\u0442\u044c \u0447\u0430\u0439","status_id":"32115415","old_status_id":"","price":"50","responsible_user_id":"5895529","last_modified":"1583659939","modified_user_id":"5895529","created_user_id":"5895529","date_create":"1583659885","pipeline_id":"3138481","account_id":"28825597","created_at":"1583659885","updated_at":"1583659939"}]},"account":{"subdomain":"spiritvl","id":"28825597","_links":{"self":"https:\/\/spiritvl.amocrm.ru"}}}';
        $request = '';
        $request = '{"leads":{"add":[{"id":"1328501","name":"\u0417\u0430\u044f\u0432\u043a\u0430","status_id":"32637415","old_status_id":"","price":"666","responsible_user_id":"5956807","last_modified":"1586881257","modified_user_id":"5956807","created_user_id":"5956807","date_create":"1586881257","pipeline_id":"3212881","account_id":"28856890","custom_fields":[{"id":"101417","name":"utm_source","values":[{"value":"youtube"}]},{"id":"101419","name":"utm_medium","values":[{"value":"smm"}]},{"id":"101421","name":"utm_campaign","values":[{"value":"video"}]},{"id":"101423","name":"utm_content","values":[{"value":"TestFontactForm"}]},{"id":"101425","name":"utm_term","values":[{"value":"newutmtango"}]},{"id":"101427","name":"clientId","values":[{"value":"1472380254.1514978721"}]}],"created_at":"1586881257","updated_at":"1586881257"}]},"account":{"subdomain":"someorg","id":"28856890","_links":{"self":"https:\/\/someorg.amocrm.ru"}}}';

        $registerService->register($request, new DateTime());

        return new JsonResponse(['ok']);
    }

    /**
     * @Route("/test-google", name="google-test")
     *
     * @param AnalyticsFacade $facade
     * @return JsonResponse
     * @throws Exception
     */
    public function google(AnalyticsFacade $facade)
    {
        $basic = new BasicAnalytics('123456789', 1);
        $event = new EventAnalytics('new_lead', 'google / cpc', '2019-10-31 29:03 | 2019-10-31 20:09 | 2019-10-31 20:15', '100');
        $campaign = new CampaignAnalytics('utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content');

        $basic->setEvent($event);
        $basic->setCampaign($campaign);

        $facade->send($basic);

        return new JsonResponse(['ok']);
    }
}
