<?php
include_once 'Helpers.php';
include_once 'Exceptions.php';
include_once 'Converter.php';

class Sumator {
    /**
     * Private instance of currencies converter
     * 
     * @var Converter $converter
     */
    private $converter;

    /**
     * Constructor for the class Sumator
     * 
     * @return Sumator
     */
    public function Sumator()
    {
        $this->converter = new Converter();
    }
    /**
     * Given an array of currencies with amounts (array of arrays),
     * and a desired currency ouput, do the sum
     * 
     * @param array $currencies
     * @return Float
     */
    public function sum(array $currencies): Float
    {
        $currentRates = $this->converter->getRates();
        $this->doValidations($currentRates, $currencies);

        $total = 0;
        foreach ($currencies as $key => $value) {
            $total += $value->amount * $currentRates[$value->type];
        }

        return $total * $currentRates[$this->converter->getBaseCurrency()];
    }

    /**
     * Given an array of currencies with amounts (array of arrays),
     * perform the validations for each value
     * 
     * @return void
     */
    private function doValidations(array $currentRates, array $currencies)
    {
        foreach ($currencies as $key => $value) {
            if (! array_key_exists($value->type, $currentRates)) {
                throw new UnknownCurrencyException(
                    "$value->type doesn't exists in currencies options." . PHP_EOL . 
                    "Supported currencies are: " . $this->converter->getRateLabels()
                );
            }
            if((! is_numeric($value->amount))) {
                throw new InvalidAmountException("$value->amount is not a valida amount");
            }
        }
    }
}