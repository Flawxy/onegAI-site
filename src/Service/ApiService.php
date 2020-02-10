<?php

namespace App\Service;

use App\Repository\PostRepository;

class ApiService
{
    private $lastChangelog;

    public function __construct(PostRepository $repo)
    {
        $this->lastChangelog = $repo->getLastChangelog();
    }

    public function getChangelogDataAsJson()
    {
        return json_encode([
            'id' => $this->lastChangelog->getId(),
            'title' => $this->lastChangelog->getTitle(),
            'botVersion' => $this->getBotLastVersion(),
            'content' => $this->lastChangelog->getContent(),
            'slug' => $this->lastChangelog->getSlug(),
            'createdAt' => $this->lastChangelog->getCreatedAt(),
            'image' => $this->lastChangelog->getImage(),
            'introduction' => $this->lastChangelog->getIntroduction()
        ]);
    }

    public function getBotLastVersion()
    {
        return preg_replace('/changelog */i', '', $this->lastChangelog->getTitle());
    }
}
