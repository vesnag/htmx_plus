<?php

declare(strict_types=1);

namespace Drupal\htmx_plus_web_1_0_app\Model;

/**
 * Represents contact data.
 */
final class Contact {

  /**
   * The ID.
   */
  private ?string $id;

  /**
   * The name.
   */
  private string $name;

  /**
   * The email.
   */
  private readonly string $email;

  /**
   * The phone.
   */
  private readonly string $phone;

  public function __construct(
    string $name,
    string $email,
    string $phone,
    ?string $id = NULL,
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->phone = $phone;
  }

  /**
   * Get the contact ID.
   */
  public function id(): ?string {
    return $this->id;
  }

  /**
   * Set the contact ID.
   *
   * @param string $id
   *   The contact ID.
   */
  public function setId(?string $id): void {
    $this->id = $id;
  }

  /**
   * Get the name.
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * Set the name.
   *
   * @param string $name
   *   The name.
   */
  public function setName(string $name): void {
    $this->name = $name;
  }

  /**
   * Get the email.
   */
  public function getEmail(): string {
    return $this->email;
  }

  /**
   * Get the phone.
   */
  public function getPhone(): string {
    return $this->phone;
  }

}
