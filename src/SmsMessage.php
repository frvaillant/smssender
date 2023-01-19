<?php

namespace francoisvaillant\Sendsms;

class SmsMessage
{

    private string $from        = '';
    private int    $phonePrefix = 33;
    private string $to          = '';
    private string $text        = '';
    private array  $errors      = [];

    const TEXT_MESSAGE_MAX_LENGTH        = 160;
    const TEXT_TOO_LONG_ERROR_MESSAGE    = 'Message trop long (doit être inférieur à 160 caractères)';
    const MALFORMED_PHONE_NUMBER_MESSAGE = 'Numéro de destinataire mal formé (10 chiffres sans espace : 0677887788)';
    const PHONE_REGEX                    = '/[0-9]{10}/';

    public function __construct(string $from, string $to, string $text)
    {
        if(strlen($text) > self::TEXT_MESSAGE_MAX_LENGTH) {
            $this->errors[] = self::TEXT_TOO_LONG_ERROR_MESSAGE;
        }
        if(!$this->isValidPhoneNumber($to)) {
            $this->errors[] = self::MALFORMED_PHONE_NUMBER_MESSAGE;
        }
        $this->setText($text);
        $this->setTo($to);
        $this->setFrom($from);
    }

    private function isValidPhoneNumber(string $number): bool
    {
        return
            preg_match(self::PHONE_REGEX, $number) &&
            substr($number, 0,1) === '0'
            ;
    }

    public function hasError(): bool
    {
        return count($this->errors) > 0;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getMessage(): ?array
    {
        if(!$this->hasError()) {
            return [
                'From' => $this->from,
                'To'   => $this->to,
                'Text' => $this->text
            ];
        }
        return null;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void
    {
        $this->to = '+' . $this->phonePrefix . substr($to,1);
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = substr($text,0,159);
    }

    /**
     * @return int
     */
    public function getPhonePrefix(): int
    {
        return $this->phonePrefix;
    }

    /**
     * @param int $phonePrefix
     */
    public function setPhonePrefix(int $phonePrefix): void
    {
        $this->phonePrefix = $phonePrefix;
    }

}