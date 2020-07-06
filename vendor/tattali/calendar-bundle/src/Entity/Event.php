<?php

declare(strict_types=1);

namespace CalendarBundle\Entity;

use DateTimeInterface;

class Event
{
    const DATE_FORMAT = 'Y-m-d\\TH:i:s.u\\Z';

    /**
     * @var string
     */
    protected $machine;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var DateTimeInterface
     */
    protected $start;

    /**
     * @var DateTimeInterface|null
     */
    protected $end;

    /**
     * @var bool
     */
    protected $allDay = true;

    /**
     * @var array
     */
    protected $options = [];

    public function __construct(
        string $machine,
        string $title,
        DateTimeInterface $start,
        ?DateTimeInterface $end = null,
        array $options = []
    ) {
        $this->setMachine($machine);
        $this->setTitle($title);
        $this->setStart($start);
        $this->setEnd($end);
        $this->setOptions($options);
    }

    public function getMachine(): ?string
    {
        return $this->machine;
    }

    public function setMachine(string $machine): void
    {
        $this->machine = $machine;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getStart(): ?DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(DateTimeInterface $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): ?DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?DateTimeInterface $end): void
    {
        if (null !== $end) {
            $this->allDay = false;
        }
        $this->end = $end;
    }

    public function isAllDay(): bool
    {
        return $this->allDay;
    }

    public function setAllDay(bool $allDay): void
    {
        $this->allDay = $allDay;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @param string|int $name
     */
    public function getOption($name)
    {
        return $this->options[$name];
    }

    /**
     * @param string|int $name
     */
    public function addOption($name, $value): void
    {
        $this->options[$name] = $value;
    }

    /**
     * @param string|int $name
     *
     * @return mixed|null
     */
    public function removeOption($name)
    {
        if (!isset($this->options[$name]) && !\array_key_exists($name, $this->options)) {
            return null;
        }

        $removed = $this->options[$name];
        unset($this->options[$name]);

        return $removed;
    }

    public function toArray(): array
    {
        $event = [
            'title' => $this->getMachine(),
            'start' => $this->getStart()->format(self::DATE_FORMAT),
            'allDay' => $this->isAllDay(),
        ];

        if (null !== $this->getEnd()) {
            $event['end'] = $this->getEnd()->format(self::DATE_FORMAT);
        }

        return array_merge($event, $this->getOptions());
    }
}