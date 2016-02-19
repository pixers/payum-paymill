<?php
namespace Payum\Paymill\Tests\Action;

use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Tests\GenericActionTest;
use Payum\Paymill\Action\StatusAction;

class StatusActionTest extends GenericActionTest
{
    protected $actionClass = StatusAction::class;

    protected $requestClass = GetHumanStatus::class;

    /**
     * @test
     */
    public function shouldMarkNewIfDetailsEmpty()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([]));

        $this->assertTrue($status->isNew());
    }

    /**
     * @test
     */
    public function shouldMarkFailedIfHttpStatusCodeNot200()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 400,
        ]));

        $this->assertTrue($status->isFailed());
    }

    /**
     * @test
     */
    public function shouldMarkFailedIfNoTransaction()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
        ]));

        $this->assertTrue($status->isFailed());
    }

    /**
     * @test
     */
    public function shouldMarkPendingIfResponseCode()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 10002,
            ],
        ]));

        $this->assertTrue($status->isPending());
    }

    /**
     * @test
     */
    public function shouldMarkFailedIfResponseCodeNot20000()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20001,
            ],
        ]));

        $this->assertTrue($status->isFailed());
    }

    /**
     * @test
     */
    public function shouldMarkPendingIfStatusIsOpen()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'open',
            ],
        ]));

        $this->assertTrue($status->isPending());
    }

    /**
     * @test
     */
    public function shouldMarkPendingIfStatusIsPending()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'pending',
            ],
        ]));

        $this->assertTrue($status->isPending());
    }

    /**
     * @test
     */
    public function shouldMarkPendingIfStatusIsPreauthorize()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'preauthorize',
            ],
        ]));

        $this->assertTrue($status->isPending());
    }

    /**
     * @test
     */
    public function shouldMarkPendingIfStatusIsPreauth()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'preauth',
            ],
        ]));

        $this->assertTrue($status->isPending());
    }

    /**
     * @test
     */
    public function shouldMarkCaptureIfStatusIsClosed()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'closed',
            ],
        ]));

        $this->assertTrue($status->isAuthorized());
    }

    /**
     * @test
     */
    public function shouldMarkFailedIfStatusIsFailed()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'failed',
            ],
        ]));

        $this->assertTrue($status->isFailed());
    }

    /**
     * @test
     */
    public function shouldMarkRefundedIfStatusIsRefunded()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'refunded',
            ],
        ]));

        $this->assertTrue($status->isRefunded());
    }

    /**
     * @test
     */
    public function shouldMarkRefundedIfStatusIsPartialRefunded()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'partial_refunded',
            ],
        ]));

        $this->assertTrue($status->isRefunded());
    }

    /**
     * @test
     */
    public function shouldMarkRefundedIfStatusIsPartaillyRefunded()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'partially_refunded',
            ],
        ]));

        $this->assertTrue($status->isRefunded());
    }

    /**
     * @test
     */
    public function shouldMarkUnknownIfStatusIsUnknown()
    {
        $action = new StatusAction();

        $action->execute($status = new GetHumanStatus([
            'http_status_code' => 200,
            'transaction' => [
                'response_code' => 20000,
                'status' => 'somestatus',
            ],
        ]));

        $this->assertTrue($status->isUnknown());
    }
}
