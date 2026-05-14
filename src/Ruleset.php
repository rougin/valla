<?php

namespace Rougin\Valla;

use Rougin\Valla\Rules\Accepted;
use Rougin\Valla\Rules\Alpha;
use Rougin\Valla\Rules\AlphaNum;
use Rougin\Valla\Rules\ArrayHasKeys;
use Rougin\Valla\Rules\ArrayRule;
use Rougin\Valla\Rules\Ascii;
use Rougin\Valla\Rules\Between;
use Rougin\Valla\Rules\Boolean;
use Rougin\Valla\Rules\Contains;
use Rougin\Valla\Rules\ContainsUnique;
use Rougin\Valla\Rules\CreditCard;
use Rougin\Valla\Rules\Date;
use Rougin\Valla\Rules\DateAfter;
use Rougin\Valla\Rules\DateBefore;
use Rougin\Valla\Rules\DateFormat;
use Rougin\Valla\Rules\Different;
use Rougin\Valla\Rules\Email;
use Rougin\Valla\Rules\EmailDNS;
use Rougin\Valla\Rules\Equals;
use Rougin\Valla\Rules\In;
use Rougin\Valla\Rules\Integer;
use Rougin\Valla\Rules\Ip;
use Rougin\Valla\Rules\Ipv4;
use Rougin\Valla\Rules\Ipv6;
use Rougin\Valla\Rules\IsInstance;
use Rougin\Valla\Rules\Length;
use Rougin\Valla\Rules\LengthBetween;
use Rougin\Valla\Rules\LengthMax;
use Rougin\Valla\Rules\LengthMin;
use Rougin\Valla\Rules\ListContains;
use Rougin\Valla\Rules\Max;
use Rougin\Valla\Rules\Min;
use Rougin\Valla\Rules\NotIn;
use Rougin\Valla\Rules\Numeric;
use Rougin\Valla\Rules\Optional;
use Rougin\Valla\Rules\Regex;
use Rougin\Valla\Rules\Required;
use Rougin\Valla\Rules\RequiredWith;
use Rougin\Valla\Rules\RequiredWithout;
use Rougin\Valla\Rules\Slug;
use Rougin\Valla\Rules\Subset;
use Rougin\Valla\Rules\Url;
use Rougin\Valla\Rules\UrlActive;

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
        $this->addRule(new Accepted);
        $this->addRule(new Alpha);
        $this->addRule(new AlphaNum);
        $this->addRule(new ArrayHasKeys);
        $this->addRule(new ArrayRule);
        $this->addRule(new Ascii);
        $this->addRule(new Between);
        $this->addRule(new Boolean);
        $this->addRule(new Contains);
        $this->addRule(new ContainsUnique);
        $this->addRule(new CreditCard);
        $this->addRule(new Date);
        $this->addRule(new DateAfter);
        $this->addRule(new DateBefore);
        $this->addRule(new DateFormat);
        $this->addRule(new Different);
        $this->addRule(new Email);
        $this->addRule(new EmailDNS);
        $this->addRule(new Equals);
        $this->addRule(new In);
        $this->addRule(new Integer);
        $this->addRule(new Ip);
        $this->addRule(new Ipv4);
        $this->addRule(new Ipv6);
        $this->addRule(new IsInstance);
        $this->addRule(new Length);
        $this->addRule(new LengthBetween);
        $this->addRule(new LengthMax);
        $this->addRule(new LengthMin);
        $this->addRule(new ListContains);
        $this->addRule(new Max);
        $this->addRule(new Min);
        $this->addRule(new NotIn);
        $this->addRule(new Numeric);
        $this->addRule(new Optional);
        $this->addRule(new Regex);
        $this->addRule(new Required);
        $this->addRule(new RequiredWith);
        $this->addRule(new RequiredWithout);
        $this->addRule(new Slug);
        $this->addRule(new Subset);
        $this->addRule(new Url);
        $this->addRule(new UrlActive);
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
