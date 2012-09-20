<?php
class Home extends Controller{
	private static $view;
	
	public function __construct () {
		self::$view = 'Home';
		if ($this->ajax()) {
			$this->showLayer (false);
		} else {
			$this->setView('title', 'Prueba de bootstrap');
		}
	}
	
	public function send () {
		$error = '';
		if (empty($_POST['from'])) {
			$error .= "Falta campo de\n";
		}
		$from = $_POST['from'];
		unset($_POST['from']);
		if (empty($_POST['to'])) {
			$error .= "Falta campo para\n";
		}
		$to = $_POST['to'];
		unset($_POST['to']);
		if (empty($_POST['msj'])) {
			$error .= "Falta el mensaje\n";
		}
		$msj = $_POST['msj'];
		unset($_POST['msj']);
		if (empty($_POST['subject'])) {
			$error .= "Falta el asunto\n";
		}
		$asunto = $_POST['subject'];
		unset($_POST['subject']);
		if (!empty($error)) {
			return $error;
		}
		$_POST['attach'] = $_FILES;
		Helper::sendMail ($asunto, $msj, $from, $to, $_POST);
		return 'Mensaje enviado';
	}
	
	public function modal () {
		if ($this->ajax()) {
			$this->showLayer(false);
		}
		$this->render(self::$view);
	}

	public function hola ($msj, $type='out') {
		$this->message($type, urldecode($msj));
		$this->render(self::$view);
	}

	public function model () {
		$user = new Usuario();
		print_r($user->read()->toArray());
	}
	
	public function main () {
		if (strrpos($_SERVER['REQUEST_URI'], 'home') || strrpos($_SERVER['REQUEST_URI'], 'main')) {
			Helper::redirect(ROOT);
		}
		$this->render(self::$view);
	}
}