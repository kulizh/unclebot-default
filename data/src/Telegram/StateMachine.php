<?php
namespace Unclebot\Telegram;

class StateMachine
{
    private User $user;
    private string $message;
    private ResponseText $responseText;

    public function __construct(User $user, string $message, ResponseText $responseText)
    {
        $this->user = $user;
        $this->message = $message;
        $this->responseText = $responseText;
    }

    public function handle(): array
    {
        $state = $this->user->state->get();

        switch ($state) {
            default:
                return array();
        }
    }
}
