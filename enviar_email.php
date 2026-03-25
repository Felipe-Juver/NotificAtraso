<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

function enviarEmailAtraso($emailResponsavel, $dados) {

    $mail = new PHPMailer(true);

    try {
        // CONFIGURAÇÃO SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cae.sa@iffarroupilha.edu.br';
        $mail->Password   = 'ieek idid ghpk jdgt'; // senha de app
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // 🔎 ATIVAR DEBUG (TEMPORÁRIO PARA TESTE)
        // $mail->SMTPDebug = 2;
        

        // REMETENTE
        $mail->setFrom('cae.sa@iffarroupilha.edu.br', 'CAE');
        //Mudar destinatario
        // DESTINATÁRIO
        
        $mail->addAddress(trim($emailResponsavel));


        // ===== TRATAMENTO SEGURO DE DATA =====
        $dataFormatada = '';
        $horaFormatada = '';

        if (!empty($dados['data_hora'])) {
            $dataHora = DateTime::createFromFormat('Y-m-d H:i', $dados['data_hora']);
            
            if ($dataHora) {
                $dataFormatada = $dataHora->format('d/m/Y');
                $horaFormatada = $dataHora->format('H:i');
            } else {
                $dataFormatada = $dados['data_hora'];
                $horaFormatada = '';
            }
        }
        // =====================================

        // CONTEÚDO
        $mail->isHTML(true);
        $mail->Subject = 'Registro de Atraso - NotificAtraso';

       $mail->Body = "
    <h2>Notificação de Atraso</h2>
    <p>Prezado(a) responsável,</p>

    <p>Informamos que o aluno <strong>{$dados['aluno']}</strong>
    (Matrícula: {$dados['matricula']}) apresentou atraso.</p>

    <ul>
        <li><strong>Data:</strong> {$dataFormatada}</li>
        <li><strong>Hora:</strong> {$horaFormatada}</li>
        <li><strong>Motivo:</strong> {$dados['motivo']}</li>
        <li><strong>Professor:</strong> {$dados['professor']}</li>
    </ul>

    <p>Em caso de dúvidas, entre em contato com o <strong>CAE</strong> 
    do Campus Santo Augusto.</p>

    <p>
        <strong>Telefones:</strong><br>
        (55) 3116-0047<br>
        (55) 3116-0048<br>
        (55) 3116-0049<br>
        Ramal: 316
    </p>

    <p>Atenciosamente,<br>
    <strong>CAE - Campus Santo Augusto</strong></p>
";

        $mail->send();
        return true;

    } catch (Exception $e) {
        echo "Erro ao enviar email: {$mail->ErrorInfo}";
        return false;
    }
}
