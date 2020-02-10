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
            'botVersion' => preg_replace('/changelog /i', '', $this->lastChangelog->getTitle()),
            'content' => $this->lastChangelog->getContent(),
            'slug' => $this->lastChangelog->getSlug(),
            'createdAt' => $this->lastChangelog->getCreatedAt(),
            'image' => $this->lastChangelog->getImage(),
            'introduction' => $this->lastChangelog->getIntroduction()
        ]);
    }
}
