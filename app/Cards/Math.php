<?php 

class Math
{
    public function operation(Money|float|string|int $number, string $type): Money
    {
        $instance = $this->getInstance($number, $this->decimals, $this->currencyCode);

        if (! $this->canPerformOperation($instance, $type)) {
            throw new \Exception('not valid operation.');
        }
        
        $current = $this->amount;
        if ($type == 'multiply') {
            $entry = $instance->number();
        } else {
            $entry = $instance->cents();
        }

        $operations = [
            'add'      => fn($a, $b) => $a + $b,
            'subtract' => fn($a, $b) => $a - $b,
            'multiply' => fn($a, $b) => $a * $b,
            'divide'   => fn($a, $b) => $a / $b,
        ];

        $result = $operations[$type]($current, $entry);

        // has decimals (divide) operations
        if (is_float($result) && floor($result) !== $result) {
            $this->amount = $this->prepare($result, $this->decimals);
        } else {
            $this->amount = (int) $result;
        }

        return $this;
    }

    public function add(Money|float|string|int $number): Money
    {
        return $this->operation($number, 'add');
    }

    public function sub(Money|float|string|int $number): Money
    {
        return $this->operation($number, 'subtract');
    }

    public function multiply(Money|float|string|int $number): Money
    {
        return $this->operation($number, 'multiply');
    }

    public function divide(Money|float|string|int $number): Money
    {
        return $this->operation($number, 'divide');
    }

    protected function canPerformOperation(Money $money, string $type): bool
    {   
        $type = strtolower($type);
        $operations = [
            'add', 
            'divide', 
            'subtract', 
            'multiply'
        ];

        if ($type === 'divide' && $money->cents() < 1 || ! in_array($type, $operations)) {
            return false;
        }

        return $this->isSameCurrency($money) && $money->cents() > 0;
    }
}