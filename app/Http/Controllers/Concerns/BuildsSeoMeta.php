<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Str;

trait BuildsSeoMeta
{
  protected function seoLimitAtWord(?string $text, int $maxChars): string
  {
    $text = (string) Str::of($text ?? '')
      ->replaceMatches('/\s+/u', ' ')
      ->trim();

    if ($text === '' || $maxChars <= 0) {
      return '';
    }

    if (Str::length($text) <= $maxChars) {
      return $text;
    }

    $cut = Str::substr($text, 0, $maxChars);
    $lastSpace = strrpos($cut, ' ');

    // Only cut back to a word boundary if it doesn't truncate too aggressively.
    if ($lastSpace !== false && $lastSpace >= (int) floor($maxChars * 0.6)) {
      $cut = Str::substr($cut, 0, $lastSpace);
    }

    return rtrim($cut, " \t\n\r\0\x0B-–—|,.;:");
  }

  /**
   * Builds meta title/description/keywords for detail pages.
   *
   * Rules:
   * - Title: max 60 chars
   * - Description: (Title max 80 chars) + fixed suffix
   * - Keywords: first 5 words, comma-separated, max 60 chars total
   */
  protected function buildSeoMeta(?string $title, string $emptyLabel = 'Products'): array
  {
    $cleanTitle = (string) Str::of($title ?? '')
      ->replaceMatches('/\s+/u', ' ')
      ->trim();

    $metaTitle = $this->seoLimitAtWord(
      $cleanTitle !== '' ? $cleanTitle : 'World Business Guide - WBG24.com',
      60
    );

    $nameForDescription = $cleanTitle !== ''
      ? $this->seoLimitAtWord($cleanTitle, 80)
      : $emptyLabel;

    $metaDescription = $nameForDescription . ' on World Business Guide - WBG24.com – Your international Market.';
    $metaDescription = $this->seoLimitAtWord($metaDescription, 160);

    $keywordBase = (string) Str::of($cleanTitle)
      ->replaceMatches('/[^\pL\pN\s]+/u', ' ')
      ->trim();

    $keywordWords = preg_split('/\s+/u', $keywordBase, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $metaKeywords = $this->seoLimitAtWord(implode(', ', array_slice($keywordWords, 0, 5)), 60);

    return [
      'metaTitle' => $metaTitle,
      'metaDescription' => $metaDescription,
      'metaKeywords' => $metaKeywords,
    ];
  }
}
