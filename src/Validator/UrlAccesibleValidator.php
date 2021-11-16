<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Service\ClienteHttp;

class UrlAccesibleValidator extends ConstraintValidator
{
    private $clienteHttp;
    
    public function __construct(ClienteHttp $clienteHttp)
    {
       $this->clienteHttp=$clienteHttp; 
    }
    
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\UrlAccesible */

        if (null === $value || '' === $value) {
            return;
        }

        $codigoEstado=$this->clienteHttp->obtenerCodigoUrl($value);
        if(null===$codigoEstado)
        {
            $codigoEstado="Error";
        }
        // TODO: implement the validation here
        if(200!==$codigoEstado)
        {
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ codigo }}', $codigoEstado)
            ->addViolation();
        }
        
    }
}
