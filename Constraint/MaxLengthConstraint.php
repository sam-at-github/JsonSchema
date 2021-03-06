<?php
namespace JsonSchema\Constraint;

use JsonSchema\Constraint\Constraint;
use JsonSchema\Constraint\Exception\ConstraintParseException;

/**
 * The maxLength constraint.
 */
class MaxLengthConstraint extends Constraint
{
  private $maxLength;

  public function __construct($maxLength) {
    $this->maxLength = (int)$maxLength;
  }

  /**
   * @override
   */
  public static function getName() {
  	return 'maxLength';
  }

  /**
   * @override
   */
  public function validate($doc, $context) {
    $valid = true;
    if(is_string($doc)) {
      if(strlen(utf8_decode($doc)) > $this->maxLength) {
        $valid = new ValidationError($this, "length of string '$doc' > {$this->maxLength}", $context);
      }
    }
    return $valid;
  }

  /**
   * @override
   */
  public static function build($context) {
    $doc = $context->maxLength;
    if(!is_int($doc)) {
      throw new ConstraintParseException('The value MUST be an integer.');
    }
    if($doc < 0) {
      throw new ConstraintParseException('This integer MUST be greater than, or equal to 0.');
    }
    return new static($doc);
  }
}
