<?php

final class CashbackCalculator
{
    public function calculate(
        Money $orderAmount,
        Money $commissionAmount,
        CashbackRule $rule,
    ): Money {
        // Example logic only
        if ($rule->isPercentageOfOrder()) {
            return $rule->percentage()->applyTo($orderAmount);
        }

        if ($rule->isPercentageOfCommission()) {
            return $rule->percentage()->applyTo($commissionAmount);
        }

        return $rule->flatAmount();
    }
}