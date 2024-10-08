<?php

declare(strict_types=1);

namespace Drupal\htmx_plus\Twig;

use Drupal\htmx_plus\Context\AttributeCheckerContext;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * HTMXExtension Twig extension.
 */
class HTMXExtension extends AbstractExtension {

  public function __construct(
    private AttributeCheckerContext $attributeCheckerContext,
  ) {}

  /**
   * Returns the HTMX attributes as HTML string.
   *
   * @return \Twig\TwigFunction[]
   *   An array of Twig functions.
   */
  public function getFunctions(): array {
    return [
      new TwigFunction('hx_attributes', [$this, 'hxAttributes'], ['is_safe' => ['html']]),
    ];
  }

  /**
   * Returns the HTMX attributes as HTML string.
   *
   * @param array<string,string> $attributes
   *   An array of HTMX attributes.
   */
  public function hxAttributes(array $attributes = []): string {
    $html_attributes = '';

    $attributes = $this->attributeCheckerContext->applyCheckers($attributes);

    foreach ($attributes as $key => $value) {
      if (!empty($value)) {
        $html_attributes .= sprintf(' hx-%s="%s"', htmlspecialchars((string) $key), htmlspecialchars($value));
      }
    }

    return $html_attributes;
  }

}
