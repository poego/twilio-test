<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Plugin\TwilioPoll\Controller;
require_once __DIR__ . '/../vendor/autoload.php';

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception as HttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class TwilioPollController extends AbstractController
{

    public function __construct()
    {}


    public function index(Application $app, Request $request)
    {
        $twiml = new \Services_Twilio_Twiml();
        $gather = $twiml->gather(array(
            'action' => 'http://'.$app['request']->getHost().$app['url_generator']->generate('twilio_poll_process'),
            'method' => 'GET',
            'timeout' => '30',
            'numDigits' => '1'
        ));
        $gather->say("これから投票を行います。1桁の作品番号を押してください。", array('language' => 'ja-jp'));
        $xml = strval($twiml);
        $response = new Response($app['twig']->render(
            'TwilioPoll/Resource/template/xml.twig',
            array('xml' => $xml)
        ),
            200,
            array('Content-Type' => 'text/xml')
        );
        return $response;
    }

    public function process(Application $app, Request $request)
    {
        $pollDigits = $app['request']->get('Digits');

        $Product = $app['eccube.repository.product']->get($pollDigits);
        $name = $Product->getName();
        $say=$name."に投票されました。ありがとうございました。";

        $twiml = new \Services_Twilio_Twiml();
        $twiml->say($say, array('language' => 'ja-jp'));
        $twiml->hangup();
        $xml = strval($twiml);
        $response = new Response($app['twig']->render(
            'TwilioPoll/Resource/template/xml.twig',
            array('xml' => $xml)
        ),
            200,
            array('Content-Type' => 'text/xml')
        );
        return $response;
    }
}