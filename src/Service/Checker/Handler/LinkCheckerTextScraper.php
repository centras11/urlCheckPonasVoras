<?php

namespace App\Service\Checker\Handler;

class LinkCheckerTextScraper extends BaseLinkChecker
{
    const ACTION_NAME = 'action-text-scrape';

    public function handleCheck(): string
    {
        $result = $this->translator->trans('text.not_found');

        if ($this->getLink()->getScrapeText()) {
            $response = $this->client->request(
                'GET',
                $this->getLink()->getUrl()
            );

            $scrapeResult = $this->validateStringExists($response->getContent(), $this->getLink()->getScrapeText());

            if ($scrapeResult) {
                return $this->translator->trans('text.found');
            }
        }

        return $result;
    }

    /**
     * @param string $content
     * @param string $scrapeText
     *
     * @return bool
     */
    protected function validateStringExists(string $content, string $scrapeText)
    {
        return str_contains($content, $scrapeText);
    }
}