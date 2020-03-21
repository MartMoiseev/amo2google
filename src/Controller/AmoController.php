<?php

namespace App\Controller;

use App\Entity\Google\BasicAnalytics;
use App\Entity\Google\CampaignAnalytics;
use App\Entity\Google\EventAnalytics;
use App\Entity\HookLog;
use App\Services\HookHandler\HookHandlerFactory;
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
        $request = '{"leads":{"status":[{"id":"3217759","name":"\u041f\u0440\u043e\u0432\u0435\u0440\u043a\u0430","status_id":"32310367","old_status_id":"32310529","price":"150","responsible_user_id":"5926249","last_modified":"1584793915","modified_user_id":"5926249","created_user_id":"5926249","date_create":"1584793093","pipeline_id":"3166297","account_id":"28841227","custom_fields":[{"id":"185989","name":"utm_source","values":[{"value":"google"}]},{"id":"186003","name":"utm_medium","values":[{"value":"cpc"}]},{"id":"186007","name":"utm_campaign","values":[{"value":"(none)"}]},{"id":"186011","name":"utm_content","values":[{"value":"(none)"}]},{"id":"186013","name":"utm_term","values":[{"value":"(none)"}]},{"id":"186015","name":"clientId","values":[{"value":"421960192.1547848071"}]}],"created_at":"1584793093","updated_at":"1584793915"}]},"account":{"subdomain":"miwejag132","id":"28841227","_links":{"self":"https:\/\/miwejag132.amocrm.ru"}}}';

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
