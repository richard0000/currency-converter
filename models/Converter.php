<?php
include_once 'Exceptions.php';
include_once 'Helpers.php';

class Converter {
    /**
     * An array of rates, initially null. It will be fetched from an API
     * 
     * @var array $rates
     */
    private $rates;
    /**
     * Variable to model configurations
     * 
     * @var array $conf
     */
    private $conf;

    /**
     * Constructor for the class Converter
     * 
     * @return Converter
     */
    public function Converter()
    {
        $this->conf = json_decode(file_get_contents('conf/main.json'));
    }

    /**
     * Return the current rates array if it's instantiated.
     * If not it's configured from a public rates API
     * 
     * @return array
     */
    public function getRates(): array
    {
        if($this->rates === null) {
            $this->rates = $this->fetchRates();
        }

        return $this->rates;
    }

    /**
     * Return the current rates as list of options to use in input
     * 
     * @return String
     */
    public function getRateLabels(): String
    {
        $rates = $this->getRates();
        $rateLabels = implode(',', array_keys($rates));

        return $rateLabels;
    }

    /**
     * Return the configured base currency
     * 
     * @return String
     */
    public function getBaseCurrency(): String
    {
        return $this->conf->baseCurrency;
    }

    /**
     * Go get the rates using a public API
     * 
     * @return array
     */
    private function fetchRates(): array
    {
        $ch = curl_init($this->conf->ratesUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        curl_close($ch);

        if(($response == null)||($response == '')) {
            throw new EmptyResponseException("Error Processing Request", 1);
        }

        $exchangeRates = json_decode($response, true);

        return $exchangeRates['rates'];
    }
}