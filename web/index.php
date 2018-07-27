<?php
/**
 * Created by PhpStorm.
 * User: svc
 * Date: 27.07.2018
 * Time: 16:30
 */
require_once '../php/autoload.php';
$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader, array(
    'cache' => '../cache',
));
$template = $twig->load('index.html.twig');
$form = new \Svc\FormGenerator();
if (!empty($_POST)) {
    if (!$form->validate($_POST)) {
        header('HTTP/1.1 400 Bad Request');
        exit($form->getLastError());
    }
    $sender = new \Svc\MailSender();
    if (!$sender->send("Somebody filled the feedback form", $form->getMailBody())) {
        header('HTTP/1.1 400 Bad Request');
        exit("Mail transfer fail");
    }
    echo "Message has been sent";
}
echo $template->render(array('form' => $form->getFormName(), 'fields' => $form->getItems()));