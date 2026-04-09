<?php
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/config.php';

function response_json($status, $message, $code = 200)
{
	http_response_code($code);
	echo json_encode([
		'status' => $status,
		'message' => $message,
	], JSON_UNESCAPED_UNICODE);
	exit;
}

function clean_text($value)
{
	return trim(strip_tags((string)$value));
}

function esc_html_email($value)
{
	return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	response_json('error', 'Invalid request method.', 405);
}

$name      = isset($_POST['name']) ? clean_text($_POST['name']) : '';
$phone     = isset($_POST['phone']) ? trim((string)$_POST['phone']) : '';
$message   = isset($_POST['message']) ? trim((string)$_POST['message']) : '';
$page_url  = isset($_POST['page_url']) ? trim((string)$_POST['page_url']) : '';
$form_name = isset($_POST['form_name']) ? clean_text($_POST['form_name']) : 'Form';
$website   = isset($_POST['website']) ? trim((string)$_POST['website']) : '';

if ($website !== '') {
	response_json('success', 'Form sent successfully.');
}

if ($phone === '') {
	response_json('error', 'Fill required fields.', 400);
}

$phone = trim((string)$phone);
$phone = preg_replace('/\s+/', ' ', $phone);

$digits_only = preg_replace('/\D/', '', $phone);
$normalized_phone = '+' . $digits_only;

if (strlen($digits_only) < 7 || strlen($digits_only) > 15) {
	response_json('error', 'Invalid phone number.', 400);
}

try {
	$mail->CharSet = 'UTF-8';
	$mail->setFrom('info@bandziuk.com', 'FelgiLab');
	$mail->addAddress('info@bandziuk.com');
	$mail->isHTML(true);

	$submitted_at = date('Y-m-d H:i:s');
	$host = !empty($_SERVER['HTTP_HOST']) ? clean_text($_SERVER['HTTP_HOST']) : 'felgilab.pl';
	$ip_address = !empty($_SERVER['REMOTE_ADDR']) ? clean_text($_SERVER['REMOTE_ADDR']) : 'Unknown';

	$mail->Subject = 'FelgiLab | ' . $form_name . ' | ' . $normalized_phone;

	$logo_url = 'https://felgilab.pl/assets/img/footer_logo.svg';

	$call_button_text = 'Zadzwoń do klienta';

	if (stripos($page_url, '/en/') !== false) {
		$call_button_text = 'Call the customer';
	} elseif (stripos($page_url, '/ru/') !== false) {
		$call_button_text = 'Позвонить клиенту';
	} elseif (stripos($page_url, '/uk/') !== false) {
		$call_button_text = 'Зателефонувати клієнту';
	}

	$attachments_info = [];
	$attachments_html = '';
	$attachments_count = 0;

	if (!empty($_FILES['wheel_photos']['name'][0])) {
		$allowedMimeTypes = [
			'image/jpeg',
			'image/png',
			'image/webp',
		];

		$maxFiles = 10;
		$maxFileSize = 5 * 1024 * 1024;

		$fileCount = count($_FILES['wheel_photos']['name']);

		if ($fileCount > $maxFiles) {
			$fileCount = $maxFiles;
		}

		for ($i = 0; $i < $fileCount; $i++) {
			$tmpName   = $_FILES['wheel_photos']['tmp_name'][$i] ?? '';
			$fileName  = $_FILES['wheel_photos']['name'][$i] ?? '';
			$fileSize  = $_FILES['wheel_photos']['size'][$i] ?? 0;
			$fileError = $_FILES['wheel_photos']['error'][$i] ?? UPLOAD_ERR_NO_FILE;

			if ($fileError === UPLOAD_ERR_NO_FILE) {
				continue;
			}

			if ($fileError !== UPLOAD_ERR_OK) {
				$upload_errors[] = $fileName . ' (error code: ' . $fileError . ')';
				continue;
			}

			if (!is_uploaded_file($tmpName)) {
				error_log('File is not a valid uploaded file: ' . $fileName);
				continue;
			}

			if ($fileSize > $maxFileSize) {
				continue;
			}

			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$mimeType = $finfo->file($tmpName);

			if (!in_array($mimeType, $allowedMimeTypes, true)) {
				continue;
			}

			$mail->addAttachment($tmpName, $fileName);

			$attachments_count++;
			$fileSizeMb = round($fileSize / 1024 / 1024, 2);

			$attachments_info[] = [
				'name' => $fileName,
				'size' => $fileSizeMb . ' MB',
				'type' => $mimeType,
			];
		}
	}

	if (!empty($attachments_info)) {
		$attachments_html .= '
			<tr>
				<td style="padding:0 32px 24px 32px;">
					<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; background:#ffffff; border:1px solid #e5e7eb; border-radius:14px;">
						<tr>
							<td style="padding:20px 24px 10px 24px; font-family:Arial,Helvetica,sans-serif; font-size:18px; line-height:1.4; font-weight:700; color:#111827;">
								Załączniki (' . $attachments_count . ')
							</td>
						</tr>';

		foreach ($attachments_info as $file) {
			$attachments_html .= '
						<tr>
							<td style="padding:0 24px 14px 24px;">
								<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px;">
									<tr>
										<td style="padding:14px 16px; font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.5; color:#111827;">
											<div><strong>Nazwa:</strong> ' . esc_html_email($file['name']) . '</div>
											<div><strong>Rozmiar:</strong> ' . esc_html_email($file['size']) . '</div>
											<div><strong>Typ:</strong> ' . esc_html_email($file['type']) . '</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>';
		}

		$attachments_html .= '
					</table>
				</td>
			</tr>';
	}

	$body  = '<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nowe zgłoszenie FelgiLab</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6;">
	<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; background:#f3f4f6;">
		<tr>
			<td align="center" style="padding:24px 12px;">
				<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:720px; border-collapse:collapse; background:#ffffff; border-radius:18px; overflow:hidden;">

					<tr>
						<td style="background:#013e64; padding:26px 32px; text-align:left;">
						</td>
					</tr>

					<tr>
						<td style="padding:32px 32px 12px 32px; font-family:Arial,Helvetica,sans-serif; color:#111827;">
							<div style="font-size:28px; line-height:1.2; font-weight:700; margin:0 0 8px 0;">
								Nowe zgłoszenie z formularza
							</div>
							<div style="font-size:15px; line-height:1.6; color:#4b5563;">
								Na stronie FelgiLab pojawiło się nowe zgłoszenie. Poniżej znajdziesz komplet informacji.
							</div>
						</td>
					</tr>

					<tr>
						<td style="padding:0 32px 24px 32px;">
							<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; background:#ffffff; border:1px solid #e5e7eb; border-radius:14px;">
								<tr>
									<td style="padding:20px 24px 10px 24px; font-family:Arial,Helvetica,sans-serif; font-size:18px; line-height:1.4; font-weight:700; color:#111827;">
										Dane kontaktowe
									</td>
								</tr>';

	if ($name !== '') {
		$body .= '
								<tr>
									<td style="padding:0 24px 10px 24px; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.6; color:#111827;">
										<strong>Imię:</strong> ' . esc_html_email($name) . '
									</td>
								</tr>';
	}

	$body .= '
								<tr>
									<td style="padding:0 24px 12px 24px; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.6; color:#111827;">
										<strong>Telefon:</strong> <a href="tel:' . esc_html_email($normalized_phone) . '" style="color:#013e64; text-decoration:none;">' . esc_html_email($phone) . '</a>
									</td>
								</tr>
								<tr>
									<td style="padding:0 24px 24px 24px;">
										<table role="presentation" cellspacing="0" cellpadding="0" border="0" style="border-collapse:separate;">
											<tr>
												<td bgcolor="#013e64" style="border-radius:10px; background-color:#013e64;">
													<a href="tel:' . esc_html_email($normalized_phone) . '" style="display:inline-block; padding:14px 22px; font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.2; font-weight:700; color:#ffffff; text-decoration:none; background-color:#013e64; border:1px solid #013e64; border-radius:10px;">
														' . esc_html_email($call_button_text) . '
													</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>';

	if ($message !== '') {
		$body .= '
					<tr>
						<td style="padding:0 32px 24px 32px;">
							<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; background:#ffffff; border:1px solid #e5e7eb; border-radius:14px;">
								<tr>
									<td style="padding:20px 24px 10px 24px; font-family:Arial,Helvetica,sans-serif; font-size:18px; line-height:1.4; font-weight:700; color:#111827;">
										Wiadomość
									</td>
								</tr>
								<tr>
									<td style="padding:0 24px 20px 24px; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.7; color:#111827; white-space:pre-line;">
										' . nl2br(esc_html_email($message)) . '
									</td>
								</tr>
							</table>
						</td>
					</tr>';
	}

	$body .= '
					<tr>
						<td style="padding:0 32px 24px 32px;">
							<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; background:#ffffff; border:1px solid #e5e7eb; border-radius:14px;">
								<tr>
									<td style="padding:20px 24px 10px 24px; font-family:Arial,Helvetica,sans-serif; font-size:18px; line-height:1.4; font-weight:700; color:#111827;">
										Szczegóły zgłoszenia
									</td>
								</tr>
								<tr>
									<td style="padding:0 24px 10px 24px; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.6; color:#111827;">
										<strong>Formularz:</strong> ' . esc_html_email($form_name) . '
									</td>
								</tr>
								<tr>
									<td style="padding:0 24px 10px 24px; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.6; color:#111827;">
										<strong>Data:</strong> ' . esc_html_email($submitted_at) . '
									</td>
								</tr>
								<tr>
									<td style="padding:0 24px 10px 24px; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.6; color:#111827;">
										<strong>Host:</strong> ' . esc_html_email($host) . '
									</td>
								</tr>
								<tr>
									<td style="padding:0 24px 10px 24px; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.6; color:#111827;">
										<strong>IP:</strong> ' . esc_html_email($ip_address) . '
									</td>
								</tr>';

	if ($page_url !== '') {
		$body .= '
								<tr>
									<td style="padding:0 24px 20px 24px; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.6; color:#111827;">
										<strong>Strona:</strong> <a href="' . esc_html_email($page_url) . '" style="color:#013e64; word-break:break-word;">' . esc_html_email($page_url) . '</a>
									</td>
								</tr>';
	} else {
		$body .= '
								<tr>
									<td style="padding:0 24px 20px 24px; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.6; color:#111827;">
										<strong>Strona:</strong> brak danych
									</td>
								</tr>';
	}

	$body .= '
							</table>
						</td>
					</tr>';

	$body .= $attachments_html;

	$body .= '
					<tr>
						<td style="padding:0 32px 32px 32px;">
							<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; background:#eef6fb; border:1px solid #d9eaf5; border-radius:14px;">
								<tr>
									<td style="padding:16px 20px; font-family:Arial,Helvetica,sans-serif; font-size:13px; line-height:1.6; color:#4b5563;">
										Ta wiadomość została wygenerowana automatycznie z formularza na stronie FelgiLab.
									</td>
								</tr>
							</table>
						</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
</body>
</html>';

	$text_body = "Nowe zgłoszenie z formularza\n";
	$text_body .= "===========================\n\n";
	$text_body .= "Formularz: " . $form_name . "\n";
	$text_body .= "Data: " . $submitted_at . "\n";
	$text_body .= "Host: " . $host . "\n";
	$text_body .= "IP: " . $ip_address . "\n";

	if ($name !== '') {
		$text_body .= "Imię: " . $name . "\n";
	}

	$text_body .= "Telefon: " . $phone . "\n";

	if ($message !== '') {
		$text_body .= "Wiadomość:\n" . $message . "\n";
	}

	if ($page_url !== '') {
		$text_body .= "Strona: " . $page_url . "\n";
	}

	if (!empty($attachments_info)) {
		$text_body .= "\nZałączniki:\n";
		foreach ($attachments_info as $file) {
			$text_body .= "- " . $file['name'] . " | " . $file['size'] . " | " . $file['type'] . "\n";
		}
	}

	$mail->Body = $body;
	$mail->AltBody = $text_body;

	if (!$mail->send()) {
		error_log('FelgiLab form mail error: ' . $mail->ErrorInfo);
		response_json('error', 'Failed to send form.', 500);
	}

	response_json('success', 'Dziękujemy! Formularz został wysłany.');
} catch (Exception $e) {
	error_log('FelgiLab form exception: ' . $e->getMessage());
	response_json('error', 'Server error. Try again later.', 500);
}
