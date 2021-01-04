<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TimeService;

class TimeController extends Controller
{
	protected $service;

	function __construct()
	{
		$this->service = new TimeService;
	}

	private function send($data, $status=200)
	{
		return response($data, $status)
			->header('Content-Type', 'application/json');
	}

    public function convert(Request $request)
    {
    	$timestamp = $request->input('timestamp');

    	if (empty($timestamp)) {
    		$error = 'Timestamp is empty';
    		return $this->send(compact('error'), 400);
    	}

    	if ($timestamp < 0) {
    		$error = 'Timestamp can\'t be a negative value';
    		return $this->send(compact('error'), 400);
    	}

    	try {
    		$response = $this->service->lapses($timestamp);
    	} catch (\Throwable $e) {
    		$error = $e->getMessage();
    		return $this->send(compact('error'), 500);
    	}

		return $this->send($response);
    }
}
