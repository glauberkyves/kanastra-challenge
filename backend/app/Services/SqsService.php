<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SqsService {

   public function send(array $data): bool {
       // @todo remover
//       Http::fake();

       return Http::post(env('AIP_SQS'), $data)->successful();
   }
}
