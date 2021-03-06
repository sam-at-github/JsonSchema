<?php
namespace JsonSchema\Constraint;

use JsonSchema\Constraint\Constraint;
use JsonSchema\Constraint\Exception\ConstraintParseException;

/**
 * The pattern constraint.
 */
class PatternConstraint extends Constraint
{
  private $pattern;

  public function __construct($pattern) {
    // Test validity. Note no such thing as a compiled regexp in PHP, but does have a cache.
    $pattern = self::fixPreg($pattern);
    if(@preg_match($pattern, "0") === false) {
      throw new \BadMethodCallException("Not a valid regular expression.");
    }
    $this->pattern = $pattern;
  }

  /**
   * @override
   */
  public static function getName() {
    return 'pattern';
  }

  /**
   * @override
   */
  public function validate($doc, $context) {
    $valid = true;
    if(is_string($doc) && !preg_match($this->pattern, $doc)) {
      $valid = new ValidationError($this, "'$doc' does not match '{$this->pattern}'", $context);
    }
    return $valid;
  }

  /**
   * @todo PCRE valid not necessarily ECMA.
   * @override
   */
  public static function build($context) {
    $constraint = null;
    $doc = $context->pattern;

    if(!is_string($doc)) {
      throw new ConstraintParseException('The value MUST be a string.');
    }
    try {
      $constraint = new static($doc);
    }
    catch(\BadMethodCallException $e) {
      throw new ConstraintParseException('This string SHOULD be a valid regular expression, according to the ECMA 262 regular expression dialect.');
    }
    return $constraint;
  }

  /**
   * According to spec patterns are of the 'ECMA 262 regular expression dialect'.
   * According to spec example such patterns have no delimiter. Try to add id not present (imperfect).
   */
  public static function fixPreg($preg) {
    if(!preg_match('/^([\/#]).*\1u?$/', $preg)) {
      $preg = "/{$preg}/u";
    }
    return $preg;
  }
}
