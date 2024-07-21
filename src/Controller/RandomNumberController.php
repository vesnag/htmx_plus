<?php

namespace Drupal\htmx_plus\Controller;

use Drupal\Core\Block\BlockManagerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\RendererInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Defines the RandomNumberController class.
 */
class RandomNumberController extends ControllerBase {

  /**
   * Constructs a new RandomNumberController object.
   *
   * @param \Drupal\Core\Block\BlockManagerInterface $blockManager
   *   The block manager.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer.
   */
  public function __construct(private BlockManagerInterface $blockManager, private RendererInterface $renderer) {
    $this->blockManager = $blockManager;
    $this->renderer = $renderer;
  }

  /**
   * Returns a random number block.
   *
   * @return array<string,mixed>
   *   The render array for the random number block.
   */
  public function randomNumberBlock(): array {

    /** @var \Drupal\htmx_plus\Plugin\Block\RandomNumberBlock $random_number_block **/
    $random_number_block = $this->blockManager->createInstance('random_number_block', []);
    $render = $random_number_block->build();

    return $render;
  }

  /**
   * Returns a random number within an HTML structure.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The HTML response containing the random number.
   */
  public function randomNumberResult(): Response {
    $random_number = rand(1, 100);
    $html_content = '<div>' . $random_number . '</div>';

    $build = [
      '#type' => 'markup',
      '#markup' => $html_content,
    ];

    $html_content = $this->renderer->renderInIsolation($build);

    return new Response($html_content);
  }

}
