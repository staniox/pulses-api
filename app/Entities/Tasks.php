<?php

declare(strict_types=1);

namespace App\Entities;

use DateTime;
use Doctrine\DBAL\Types\BooleanType;

/** @Entity */
class Tasks implements \JsonSerializable
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(TaskTypes $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDeadline(): string
    {
        return $this->deadline;
    }

    /**
     * @param string $deadline
     */
    public function setDeadline(string $deadline): void
    {
        $this->deadline = new DateTime( $deadline);
    }

    /**
     * @var string
     * @Column(type="string")
     */
    private $description;

    /**
     * @ManyToOne(targetEntity="TaskTypes")
     * @JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @var string
     * @Column(type="date")
     */
    private $deadline;

    /**
     * @var boolean
     * @Column(type="boolean", options={"default":"0"})
     */
    private $isDone;

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }

    /**
     * @param bool $isDone
     */
    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }


    public function __construct(string $description, TaskTypes $type, string $deadline, bool $isDone)
    {
        $this->description = $description;
        $this->type = $type;
        $this->deadline = new DateTime( $deadline);
        $this->isDone = $isDone;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->description;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'type_id' => $this->type,
            'deadline' => $this->deadline->format('Y-m-d'),
            'is_done' => $this->isDone
        ];
    }
}