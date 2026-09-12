<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include "connection.php";

$usuario = $_POST['txtUser'] ?? '';

$sql = "SELECT id, email FROM Usuario WHERE login = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $dados = $result->fetch_assoc();
    $userId = $dados['id'];
    $emailDestino = $dados['email'];

    $token = bin2hex(random_bytes(32));
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $update = $conn->prepare("UPDATE Usuario SET reset_token = ?, reset_expira = ? WHERE id = ?");
    $update->bind_param("ssi", $token, $expira, $userId);
    $update->execute();

    $appUrl = rtrim(getenv('APP_URL') ?: 'http://localhost:8000', '/');
    $link = "$appUrl/redefinir_senha.php?token=$token";

    $smtpHost = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
    $smtpPort = getenv('SMTP_PORT') ?: '587';
    $smtpUsername = getenv('SMTP_USERNAME');
    $smtpPassword = getenv('SMTP_PASSWORD');

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        if (!$smtpUsername || !$smtpPassword) {
            throw new Exception('Configure SMTP_USERNAME e SMTP_PASSWORD para enviar e-mails.');
        }

        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) $smtpPort;

        $mail->setFrom($smtpUsername, 'PromoSearch');
        $mail->addAddress($emailDestino);

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = 'Redefinição de Senha';
        $mail->Body = "
            <p>Olá,</p>
            <p>Você solicitou a redefinição da sua senha. Clique no link abaixo para criar uma nova senha:</p>
            <p><a href='$link'>Redefinir Senha</a></p>
            <p>Esse link expira em 1 hora.</p>
        ";

        $mail->send();
?>


<script>
alert("Um e-mail foi enviado com instruções para redefinir sua senha.");
window.history.go(-2);
</script>
<?php
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }

} else {
    echo "Usuário ou e-mail não encontrado.";
}

$conn->close();
?>
