<?php

namespace Rougin\Valla;

use Rougin\Valla\Rules\Contains;
use Rougin\Valla\Rules\CreditCard;
use Rougin\Valla\Rules\Email;
use Rougin\Valla\Rules\In;
use Rougin\Valla\Rules\IsInstance;
use Rougin\Valla\Rules\LengthMax;
use Rougin\Valla\Rules\LengthMin;
use Rougin\Valla\Rules\NotIn;
use Rougin\Valla\Rules\Numeric;
use Rougin\Valla\Rules\Required;
use Rougin\Valla\Rules\RequiredWith;
use Rougin\Valla\Rules\RequiredWithout;
use Rougin\Valla\Rules\Subset;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Ruleset
{
    /**
     * @var array<string, \Rougin\Valla\RuleInterface>
     */
    protected $rules = array();

    /**
     * Initializes the ruleset with built-in rules.
     */
    public function __construct()
    {
        $this->addRule(new Contains);
        $this->addRule(new CreditCard);
        $this->addRule(new Email);
        $this->addRule(new In);
        $this->addRule(new IsInstance);
        $this->addRule(new LengthMax);
        $this->addRule(new LengthMin);
        $this->addRule(new NotIn);
        $this->addRule(new Numeric);
        $this->addRule(new Required);
        $this->addRule(new RequiredWith);
        $this->addRule(new RequiredWithout);
        $this->addRule(new Subset);
    }

    /**
     * Registers a new rule.
     *
     * @param \Rougin\Valla\RuleInterface $rule
     *
     * @return self
     */
    public function addRule(RuleInterface $rule)
    {
        $name = $rule->getName();

        $this->rules[$name] = $rule;

        return $this;
    }

    /**
     * Resolves a rule string into configured rule instances.
     *
     * @param string $text
     *
     * @return \Rougin\Valla\RuleInterface[]
     */
    public function resolve($text)
    {
        $items = explode('|', $text);

        $rules = array();

        foreach ($items as $item)
        {
            $texts = explode(':', $item);

            // Extract the values based on the text ----
            $values = array();

            if (count($texts) > 1)
            {
                $values = explode(',', trim($texts[1]));
            }
            // -----------------------------------------

            $name = trim($texts[0]);

            // Set values based on defined rules ---
            if (isset($this->rules[$name]))
            {
                $rule = $this->rules[$name];

                $rules[] = $rule->setValue($values);

                continue;
            }
            // -------------------------------------

            $error = 'Rule "' . $name . '" not found';

            throw new \Exception($error);
        }

        return $rules;
    }
}
