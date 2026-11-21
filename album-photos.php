<?php
namespace Grav\Plugin;

use Grav\Common\Page\Page;
use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use SplFileInfo;

/**
 * Erzeugt für jedes Bild eines Albums eine virtuelle Foto-Seite.
 * Beispiel: /alben/island-im-winter/bild1 zeigt das Bild "bild1" (oder "bild1.jpg")
 * im Album /alben/island-im-winter mit dem Template aus der Plugin-Konfiguration.
 */
class AlbumPhotosPlugin extends Plugin
{
    /** @var \Grav\Common\Page\Medium\ImageMedium|null */
    private $photo = null;

    public static function getSubscribedEvents(): array
    {
        return [
            'onPagesInitialized' => ['onPagesInitialized', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
        ];
    }

    public function onPagesInitialized(Event $event): void
    {
        $config = $this->grav['config'];
        if (!$config->get('plugins.album-photos.enabled', true)) {
            return;
        }

        $route = rtrim($this->grav['uri']->path(), '/');
        $slug = basename($route);
        $albumRoute = dirname($route);
        if ($slug === '' || $albumRoute === '/' || $albumRoute === '.') {
            return;
        }

        $pages = $this->grav['pages'];
        $album = $pages->find($albumRoute);
        if (!$album || $album->template() !== 'album') {
            return;
        }

        $image = $this->findImage($album, $slug);
        if (!$image) {
            return;
        }

        $page = new Page();
        $page->init(new SplFileInfo($album->path() . '/' . $slug . '.md'));
        $page->template($this->photoTemplate($config->get('system.pages.theme')));
        $page->parent($album);
        $page->slug($slug);
        $page->title(pathinfo($image->filename, PATHINFO_FILENAME));
        $page->routable(true);
        $page->published(true);
        $page->visible(false);
        $pages->addPage($page, $route);

        $this->photo = $image;
    }

    public function onTwigSiteVariables(): void
    {
        if ($this->photo) {
            $this->grav['twig']->twig_vars['album_photo'] = $this->photo;
        }
    }

    private function findImage($album, string $slug)
    {
        foreach ($album->media()->images() as $image) {
            if ($image->filename === $slug || pathinfo($image->filename, PATHINFO_FILENAME) === $slug) {
                return $image;
            }
        }
        return null;
    }

    /** Liefert das Foto-Template für das aktive Theme (Zuordnung in der Konfiguration). */
    private function photoTemplate(?string $theme): string
    {
        $config = $this->grav['config'];
        $map = $config->get('plugins.album-photos.themes', []);
        return $map[$theme] ?? $config->get('plugins.album-photos.photo_template', 'photo');
    }
}
