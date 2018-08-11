<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use Laravel\Lumen\Application;

	class ResponseService
	{
		/**
		 * @var HelpersService
		 */
		private $helpers;

		public function __construct()
		{
			$this->helpers = app('HelpersService');
		}

		/**
		 * @param string $content
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function success($content = "")
		{
			return $this->custom(['status' => $content ? $content : "success"], 200);
		}

		/**
		 * @param $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function custom($content, $status = 200, array $headers = [], $options = 0)
		{
			if (empty($content))
				$this->custom(["data" => null]);

			return response()->json($content, $status, $headers, $options);
		}

		/**
		 * @param string $type
		 * @param string $content
		 * @param int $status
		 * @return \Illuminate\Http\JsonResponse|void
		 */
		public function error($type = "generic", $content = "", $status = 400)
		{
			switch ($type) {
				case "error":
					// A generic error with custom message and status code.
					return $this->helpers->response->error($content ? $content : 'This is an error.', 404);
					break;

				case "notFound":
					// A not found error with an optional message as the first parameter.
					return $this->helpers->response->errorNotFound($content);
					break;

				case "badRequest":
					// A bad request error with an optional message as the first parameter.
					return $this->helpers->response->errorBadRequest($content);
					break;

				case "forbidden":
					// A forbidden error with an optional message as the first parameter.
					return $this->helpers->response->errorForbidden($content);
					break;

				case "internal":
					// An internal error with an optional message as the first parameter.
					return $this->helpers->response->errorInternal($content);
					break;

				case "unauthorized":
					// An unauthorized error with an optional message as the first parameter.
					return $this->helpers->response->errorUnauthorized($content);
					break;

				case "generic":
					return $this->custom(['errors' => $content ? $content : "generic error"], $status);
					break;
			}
		}
	}