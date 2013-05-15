<?php

/**
 * Request data iterator
 *
 */
CLASS user_request_iterator EXTENDS inverted_regex_iterator {

   public $sensitive_keys_regex = '/^(pa?s?s(wo?r?d)?|c(redit)?_?c(ard)?|PHPSESSID)/';

   /**
    * Hash | Credit Card | password
    *
    */
   public $sensitive_values_regex = '
         /^(
               [0-9a-f]{32,40}
               |
               (?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$
         /x';

   /**
    * instead of returning false, we will obfuscate the data instead
    *
    *
    *
    */
   public function accept() {
      $current = $this->current();
      if (!parent::accept()) {
         if (!is_array($current)) {
            $this->OffsetSet($this->key(),static::obfuscate($current));
         }
      }
      if (preg_match($this->sensitive_values_regex, $current)) {
         $this->OffsetSet($this->key(),static::obfuscate($current));
      }
      return true;
   }

/**
 * Construct
 *
 */
   public function __construct($array) {
      parent::__construct(new RecursiveArrayIterator($array),$this->sensitive_keys_regex);

      $this->setFlags(static::USE_KEY);

      foreach ($this as $index => $value) {
         if ($this->hasChildren()) {
            $this->offsetSet($index, iterator_to_array($this->getChildren()));
         }
      }
   }

   /**
    * Obfuscate the credit card number or other details
    *
    * @param string $string
    *
    */
   public static function obfuscate($string, $obfuscation_char = '*') {
      if (!is_string($string)) {
         throw new e_developer("Wrong parameter for ".__FUNCTION__,$string);
      }
      $len = strlen($string);
      return preg_replace('/\S(?!.{0,'.(round(($len/4)-1)).'}$)/',$obfuscation_char,$string);
   }

}