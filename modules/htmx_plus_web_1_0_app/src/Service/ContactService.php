<?php

declare(strict_types=1);

namespace Drupal\htmx_plus_web_1_0_app\Service;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\htmx_plus_web_1_0_app\Model\ContactData;

/**
 * Service for handling contacts.
 */
class ContactService {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a ContactService object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(Connection $database, EntityTypeManagerInterface $entity_type_manager) {
    $this->database = $database;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Searches for contacts based on criteria.
   *
   * @param string $search
   *   The search query.
   *
   * @return array<int, array<string, mixed>>
   *   An array of contacts, where each contact is an associative array.
   */
  public function search(string $search): array {
    $query = $this->database->select('contacts', 'c')
      ->fields('c')
      ->condition('name', '%' . $this->database->escapeLike($search) . '%', 'LIKE');

    /** @var \Drupal\Core\Database\StatementInterface|array[] $statement */
    $statement = $query->execute();
    $result = $statement->fetchAll();

    return $result;
  }

  /**
   * Saves a contact.
   *
   * @param \Drupal\htmx_plus_web_1_0_app\Model\ContactData $contact_data
   *   The contact data.
   */
  public function saveContact(ContactData $contact_data): void {
    $this->database->insert('contacts')
      ->fields([
        'name' => $contact_data->getName(),
        'email' => $contact_data->getEmail(),
        'phone' => $contact_data->getPhone(),
      ])
      ->execute();
  }

  /**
   * Retrieves all contacts.
   *
   * @return array<int, array<string, mixed>>
   *   An array of all contacts, where each contact is an associative array.
   */
  public function all(): array {
    $query = $this->database->select('contacts', 'c')
      ->fields('c');
    /** @var \Drupal\Core\Database\StatementInterface|array[] $statement */
    $statement = $query->execute();
    $result = $statement->fetchAll();

    return $result;
  }

  /**
   * Retrieves a contact by its ID.
   *
   * @param string $contact_id
   *   The contact ID.
   *
   * @return array<string, mixed>|bool
   *   An associative array representing the contact, or FALSE if not found.
   */
  public function getContactById(string $contact_id): array|bool {
    $query = $this->database->select('contacts', 'c')
      ->fields('c', ['id', 'name', 'email', 'phone'])
      ->condition('id', $contact_id);

    /** @var \Drupal\Core\Database\StatementInterface|array[] $statement */
    $statement = $query->execute();
    return $statement->fetchAssoc();
  }

  /**
   * Updates a contact.
   *
   * @param \Drupal\htmx_plus_web_1_0_app\Model\ContactData $contact_data
   *   The contact data.
   */
  public function updateContact(ContactData $contact_data): void {
    $this->database->update('contacts')
      ->fields([
        'name' => $contact_data->getName(),
        'email' => $contact_data->getEmail(),
        'phone' => $contact_data->getPhone(),
      ])
      ->condition('id', $contact_data->getId())
      ->execute();
  }

  /**
   * Deletes a contact.
   */
  public function deleteContact(string $contact_id): void {
    $this->database->delete('contacts')
      ->condition('id', $contact_id)
      ->execute();
  }

}
