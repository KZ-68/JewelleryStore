<?php

namespace Tests\Unit;

use App\Services\Payment\CountryBasedStripePaymentMethodsResolver;
use Tests\TestCase;

class CountryBasedStripePaymentMethodsResolverTest extends TestCase
{
    private CountryBasedStripePaymentMethodsResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new CountryBasedStripePaymentMethodsResolver();
    }

    public function test_resolve_returns_methods_for_known_country_code(): void
    {
        $methods = $this->resolver->resolve('BE');

        $this->assertContains('card', $methods);
        $this->assertContains('bancontact', $methods);
    }

    public function test_resolve_returns_methods_for_nl(): void
    {
        $methods = $this->resolver->resolve('NL');

        $this->assertContains('card', $methods);
        $this->assertContains('ideal', $methods);
    }

    public function test_resolve_returns_methods_for_de(): void
    {
        $methods = $this->resolver->resolve('DE');

        $this->assertContains('sepa_debit', $methods);
    }

    public function test_resolve_extracts_country_code_from_bcp47_locale(): void
    {
        $methodsFromLocale = $this->resolver->resolve('fr-FR');
        $methodsDirect     = $this->resolver->resolve('FR');

        $this->assertSame($methodsDirect, $methodsFromLocale);
    }

    public function test_resolve_extracts_country_code_from_nl_be_locale(): void
    {
        $methodsFromLocale = $this->resolver->resolve('nl-BE');
        $methodsDirect     = $this->resolver->resolve('BE');

        $this->assertSame($methodsDirect, $methodsFromLocale);
    }

    public function test_resolve_falls_back_to_default_for_unknown_country(): void
    {
        $methods = $this->resolver->resolve('JP');

        $this->assertSame(['card'], $methods);
    }

    public function test_resolve_falls_back_to_default_for_unknown_locale(): void
    {
        $methods = $this->resolver->resolve('ja-JP');

        $this->assertSame(['card'], $methods);
    }

    public function test_resolve_always_returns_an_array(): void
    {
        $this->assertIsArray($this->resolver->resolve('FR'));
        $this->assertIsArray($this->resolver->resolve('UNKNOWN'));
    }
}
