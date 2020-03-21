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
        $request = '{"leads":{"status":[{"id":"2473457","name":"\u0417\u0430\u044f\u0432\u043a\u0430 \u0441 \u0441\u0430\u0439\u0442\u0430 \u2116590788 \u0438\u0437 \u0444\u043e\u0440\u043c\u044b \u00ab\u0424\u043e\u0440\u043c\u0430 #1583562802\u00bb","status_id":"32115424","old_status_id":"32115415","price":"","responsible_user_id":"5895529","last_modified":"1584791858","modified_user_id":"5895529","created_user_id":"0","date_create":"1584383256","pipeline_id":"3138481","tags":[{"id":"24141","name":"\u0417\u0430\u044f\u0432\u043a\u0430 \u0441 \u0441\u0430\u0439\u0442\u0430"}],"account_id":"28825597","custom_fields":[{"id":"105335","name":"utm_source","values":[{"value":"google"}]},{"id":"105337","name":"utm_medium","values":[{"value":"cpc"}]},{"id":"105339","name":"utm_campaign","values":[{"value":"none"}]},{"id":"105341","name":"utm_content","values":[{"value":"none"}]},{"id":"105343","name":"utm_term","values":[{"value":"none"}]},{"id":"143913","name":"clientId","values":[{"value":"421960192.1547848071"}]}],"created_at":"1584383256","updated_at":"1584791858"}]},"account":{"subdomain":"spiritvl","id":"28825597","_links":{"self":"https:\/\/spiritvl.amocrm.ru"}}}';

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
