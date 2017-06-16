<?php 
/*
 *
 * (c) Gonzalo Moreno C. <goncab380@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Sig\FichasocialBundle\Validator\Constraints;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;
 
/**
 * @Annotation
 */
class Rut extends Constraint
{
    public $message = 'Este valor no es un RUT válido.';

    public function __construct($options = null)
    {
        parent::__construct($options);
    }
}