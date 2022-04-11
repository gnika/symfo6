<?php

namespace App\Service;

class NewMailer implements MailerInterface
{
    private $transport;
    private $bus;
    private $dispatcher;
    public function __construct(TransportInterface $transport,
                                MessageBusInterface $bus = null, EventDispatcherInterface
                                $dispatcher = null)
    {
        $this->transport = $transport;
        $this->bus = $bus;
        $this->dispatcher = class_exists(Event::class) ?
            LegacyEventDispatcherProxy::decorate($dispatcher) : $dispatcher;
    }
    public function send(RawMessage $message, Envelope $envelope =
    null): void
    {
        if (null === $this->bus) {
            $this->transport->send($message, $envelope);
            return;
        }
        if (null !== $this->dispatcher) {
            $clonedMessage = clone $message;
            $clonedEnvelope = null !== $envelope ? clone $envelope :
                Envelope::create($clonedMessage);
            $event = new MessageEvent($clonedMessage,
                $clonedEnvelope, (string) $this->transport, true);
            $this->dispatcher->dispatch($event);
        }
        $this->bus->dispatch(new SendEmailMessage($message,
            $envelope));
    }
}