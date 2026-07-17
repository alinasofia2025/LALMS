<?php

declare(strict_types=1);

namespace App\Controller;

class FilesController extends AppController
{
    public function download(?string $filename = null)
    {
        $filename = basename((string)$filename);
        if ($filename === '') {
            $this->Flash->error(__('Invalid file specified.'));
            return $this->redirect($this->referer(['action' => 'index']));
        }

        $filePath = WWW_ROOT . 'files' . DS . $filename;
        if (!is_file($filePath) || !file_exists($filePath)) {
            $this->Flash->error(__('The requested file could not be found.'));
            return $this->redirect($this->referer(['action' => 'index']));
        }

        return $this->response->withFile($filePath, [
            'download' => true,
            'name' => $filename,
        ]);
    }
}
