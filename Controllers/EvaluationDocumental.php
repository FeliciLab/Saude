<?php
namespace Saude\Controllers;

use Exception;
use \MapasCulturais\App;
use MapasCulturais\Entities\Registration;

class EvaluationDocumental extends \MapasCulturais\Controller {
    public function GET_sendMailRegistrationEvaluation() 
    {
        $app = App::i();       

        if ((int) $this->data['id']) {
            $registrationId = $this->data['id'];

            $registration = $app->repo("Registration")->find($registrationId);
            if ($registration) {
                $evaluation = null;
                if(isset($this->data['uid'])){
                    $evaluation = $app->repo('RegistrationEvaluation')->findOneBy([
                        'registration' => $registration,
                        'user' => $this->data['uid']
                    ]);
                    if($evaluation && !$evaluation->registration->equals($registration)){
                        $evaluation = null;
                    }
                }

                $app->em->remove($evaluation);
                $app->em->flush();

                $registration->setStatusToDraft();

                $fieldInvalids = '';
                $fieldInvalids .= '<ul>';
                foreach ($evaluation->evaluationData as $evaluationData) {
                    if ($evaluationData && $evaluationData['evaluation'] == 'invalid') {
                        $observacao = !empty($observacao) ? ' Observação: ' .  $evaluationData['obs'] : '';
                        $fieldInvalids .= '<li style="color:red !important;"><b>' . $evaluationData['label'] . '</b>' . $observacao . '</li>';
                    }
                }
                $fieldInvalids .= '</ul>';

                $urlOpportunity = $app->getBaseUrl() . 'oportunidade/' . $registration->opportunity->id;

                $dataValue = [
                    'urlOpportunity' => $urlOpportunity,
                    'registrationId' => $registration->id,
                    'opportunity' => $registration->opportunity->name,
                    'name' => $registration->owner->name,
                    'fieldInvalids' => $fieldInvalids,
                ];

                $message = $app->renderMailerTemplate('send_mail_registration_evaluation', $dataValue);

                $app->createAndSendMailMessage([
                    'from' => $app->config['mailer.from'],
                    'to' => $registration->owner->user->email,
                    'subject' => 'MAPA DA SAÚDE - ALERTA DE DOCUMENTAÇÃO INVÁLIDA.',
                    'body' => $message['body']
                ]);

               return $this->json(['message' => 'Envio do e-mail realizado com sucesso.', 'type' => 'success', 'status' => 200], 200);
            }
        }      
    }
}