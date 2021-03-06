<?php

use \JsonSchema\Constraint\EmptyConstraint;
use \JsonSchema\Constraint\Exception\ConstraintParseException;

/**
 * Basic tests.
 */
class EmptyConstraintTest extends ConstraintTest
{
  public function constraintDataProvider() {
    return [
      ['{}', false, true],
      ['{}', 5, true],
      ['{}', 5.6, true],
      ['{}', "String", true],
      ['{}', '{}', true],
      ['{}', '{"a":0, "b":1, "c":2}', true],
      ['{"a":0, "b":1, "c":2, "d":{}}', false, true],
      ['{"a":0, "b":1, "c":2, "d":{}}', 5, true],
      ['{"a":0, "b":1, "c":2, "d":{}}', 5.6, true],
      ['{"a":0, "b":1, "c":2, "d":{}}', "String", true],
      ['{"a":0, "b":1, "c":2, "d":{}}', '{}', true],
      ['{"a":0, "b":1, "c":2, "d":{}}', '{"a":0, "b":1, "c":2}', true]
    ];
  }

  /**
   *
   */
  public function invalidConstraintDataProvider() {
    return [[5]];
  }
}
