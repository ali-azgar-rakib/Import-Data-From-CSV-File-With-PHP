<?php

declare(strict_types=1);

function getFiles(string $directory): array
{
    $files = [];
    foreach (scandir($directory) as $file) {
        if (is_dir($file)) continue;
        $files[] = FILES_PATH . $file;
    }

    return $files;
}

function getTransactions(array $files, ?callable $transactionHandler = null): array
{

    $transactions = [];
    foreach ($files as $file) {

        $file = fopen($file, 'r');
        fgetcsv($file);
        while (($transaction = fgetcsv($file)) !== false) {
            $transactions[] = $transactionHandler($transaction);
        }
    }

    return $transactions;
}

function formatTransaction(array $transaction): array
{
    [$date, $check, $description, $amount] = $transaction;

    $amount = (float)str_replace(['$', ','], '', $amount);

    return [
        'date' => $date,
        'check' => $check,
        'description' => $description,
        'amount' => $amount
    ];
}

function calculateTotal(array $transactions): array
{
    $totals = ['netProfit' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

    foreach ($transactions as $transaction) {
        $totals['netProfit'] += $transaction['amount'];

        if ($transaction['amount'] > 0) {
            $totals['totalIncome'] += $transaction['amount'];
        } else {
            $totals['totalExpense'] += $transaction['amount'];
        }
    }

    return $totals;
}
