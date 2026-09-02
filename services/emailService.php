<?php
require_once __DIR__ . '/../models/Service.php';

require_once __DIR__ . '/../models/User.php';
class EmailService
{
    public function enviarServicoFinalizado(User $user, Service $service): bool
    {
        $destinatario = $user->getEmail();
        $nomeUsuario = htmlspecialchars($user->getName());
        $descricao = htmlspecialchars($service->getDescription());
        $preco = number_format($service->getPrice(), 2, ',', '.');
        $comissao = number_format($service->getCommissionUser(), 2, ',', '.');
        $assunto = "Serviço finalizado - JM Informática";
        $data_finalizacao = date(
            'd/m/Y',
            strtotime($service->getFinishedAt())
        );
        $mensagem = "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <body style='margin: 0; padding: 0; background: #f4f4f4; font-family: Arial,sans-serif;'>

            <div style='max-width: 100%; margin: 30px auto; background: #fff; border-radius: 10px; overflow: hidden;'>

                <div style='background: #e72525; padding: 25px; text-align: center;'>
                    <h1 style='color: #fff; margin:0;'>
                        JM Informática
                    </h1>

                    <p style='color: #cbd5e1;'>
                        Atualização do seu serviço
                    </p>
                </div>

                <div style='padding: 30px;'>

                    <h2 style='color: #1e293b;'>
                        Olá, {$nomeUsuario}! 
                    </h2>

                    <p style='color: #475569; line-height: 1.6;'>
                        Temos uma ótima notícia!
                        Seu serviço foi <strong>finalizado com sucesso</strong>.
                    </p>

                    <div style='background: #f8fafc; padding: 20px; margin: 25px 0; border-left: 4px solid #22c55e;'>

                        <p style='color: #64748b;'>
                            <strong>Serviço:</strong>
                        </p>

                        <p style='color: #1e293b;'>
                            {$descricao}
                        </p>

                        <p style='color: #64748b;'>
                            <strong>Valor:</strong>
                        </p>

                        <p style='font-size: 18px; font-weight: bold;'>
                            R$ {$preco}
                        </p>
                        <p style='color: #64748b;'>
                            <strong>Comissão:</strong>
                        </p>

                        <p style='color: #166534; font-size: 18px; font-weight: bold;'>
                            R$ {$comissao}
                        </p>
                        <p style='color: #64748b;'>
                            <strong>Data de Finalização:</strong>
                        </p>

                        <p style='color: #1e293b; font-size: 18px; font-weight: bold;'>
                            {$data_finalizacao}
                        </p>

                    </div>

                    <div style='text-align: center; margin: 30px 0;'>

                        <span style='background: #dcfce7; color: #166534; padding: 10px 20px; border-radius: 20px; font-weight: bold;'>
                             Serviço finalizado
                        </span>

                    </div>

        

                </div>

                <div style='background: #f8fafc; padding:20px; text-align: center;'>

                    <p style='color: #94a3b8; font-size: 12px;'>
                        © " . date('Y') . " JM Informática
                    </p>

                    <p style='color: #94a3b8; font-size: 12px;'>
                        Este é um e-mail automático.
                    </p>

                </div>

            </div>

        </body>
        </html>
        ";
      
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return mail(
            $destinatario,
            $assunto,
            $mensagem,
            $headers
        );
    }
}