<?php

namespace App\Helpers;


class APIHelper
{
    /**
     * @var string
     */
    public $authProvider;
    /**
     * @var string
     */
    public $authID;
    /**
     * @var string
     */
    public $token;


    /**
     * APIHelper constructor.
     * @param string $authProvider
     * @param string $authID
     * @param string $token
     */
    function __construct(string $authProvider, string $authID, string $token)
    {
        $this->authProvider = $authProvider;
        $this->authID = $authID;
        $this->token = $token;
    }


    protected function get($url)
    {
        return RequestHelper::get($url, $this->authProvider, $this->authID, $this->token);

    }

    public function getAccount(string $swiftBankCode, string $accountID, string $viewID)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/accounts/%s/%s/account', [$swiftBankCode, $accountID, $viewID]);
        return $this->get($url);
    }

    public function getAccountIDAndBankIDFromIBAN(string $iban)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/accounts/getid/%s', $iban);
        return $this->get($url);

    }

    public function getAccounts(string $swiftBankCode)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/accounts', [$swiftBankCode]);
        return $this->get($url);
    }

    public function getAccountsPrivate(string $swiftBankCode)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/accounts/public', [$swiftBankCode]);
        return $this->get($url);
    }

    public function getAccountsPublic(string $swiftBankCode)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/accounts/Public', [$swiftBankCode]);
        return $this->get($url);
    }

    public function getATM(string $swiftBankCode, string $atmID)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/atms/%s', [$swiftBankCode, $atmID]);
        return $this->get($url);
    }

    public function getATMs(string $swiftBankCode)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/atms', [$swiftBankCode]);
        return $this->get($url);
    }

    public function getBank(string $swiftBankCode)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s', [$swiftBankCode]);
        return $this->get($url);
    }

    public function getBanks()
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks');
        return $this->get($url);
    }

    public function getBranch(string $swiftBankCode, string $branchID)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/branches/%s', [$swiftBankCode, $branchID]);
        return $this->get($url);
    }

    public function getBranches(string $swiftBankCode)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/branches', [$swiftBankCode]);
        return $this->get($url);
    }

    public function getCustomer(string $swiftBankCode, string $customerID)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/customers/%s', [$swiftBankCode, $customerID]);
        return $this->get($url);
    }

    public function getCustomerOwner(string $swiftBankCode)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/customer', [$swiftBankCode]);
        return $this->get($url);
    }

    public function getProduct(string $swiftBankCode, string $productID)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/products/%s', [$swiftBankCode, $productID]);
        return $this->get($url);
    }

    public function getProducts(string $swiftBankCode)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/products', [$swiftBankCode]);
        return $this->get($url);
    }

    public function getTransaction(string $swiftBankCode, string $accountID, string $viewID)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/accounts/%s/%s/transactions/%s/transaction', [$swiftBankCode, $accountID, $viewID]);
        return $this->get($url);
    }

    public function getTransactions(string $swiftBankCode, string $accountID, string $viewID)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/accounts/%s/%s/transactions', [$swiftBankCode, $accountID, $viewID]);
        return $this->get($url);

    }

    public function getViews(string $swiftBankCode)
    {
        $url = sprintf('http://api.bocapi.net/v1/api/banks/%s/views', [$swiftBankCode]);
        return $this->get($url);
    }

    public function postMakeTransaction(string $swiftBankCode, string $accountID)
    {

    }

    public function postMakePayment(string $swiftBankCode, string $accountID)
    {
        $this->postMakeTransaction($swiftBankCode, $accountID);
    }


}