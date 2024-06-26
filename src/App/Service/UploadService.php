<?php

namespace Code\App\Service;

class UploadService
{
    public function upload($arquivo, $subpasta = null, $imagemRemover = null)
    {
        $extensao = strrchr($arquivo['name'], '.');
        $novoNome = md5($arquivo['name']) . uniqid() . $extensao;

        if (!is_dir(PASTA_UPLOADS)) {
            mkdir(PASTA_UPLOADS, 755, true);
        }

        if (!is_dir(PASTA_UPLOADS . $subpasta)) {
            mkdir(PASTA_UPLOADS . $subpasta, 755, true);
        }

        $novoNome = $subpasta ?  $subpasta . '/' . $novoNome
            : $novoNome;

        if (!move_uploaded_file($arquivo['tmp_name'], PASTA_UPLOADS . $novoNome)) {
            return false;
        }

        if ($imagemRemover && file_exists(PASTA_UPLOADS . $imagemRemover)) {
            unlink(PASTA_UPLOADS . $imagemRemover);
        }

        return $novoNome;
    }

    public function uploadMultiplosArquivos($arquivos, $subpasta)
    {
        $arquivosNomalizados = $this->normalizarUploadData($arquivos);

        $arquivosUpados = [];
        foreach ($arquivosNomalizados as $arquivo) {
            $arquivosUpados[] = $this->upload($arquivo, $subpasta);
        }

        return $arquivosUpados;
    }

    protected function normalizarUploadData($arquivos): array
    {
        $arquivosNormalizados = [];

        for ($i = 0; $i < count($arquivos['name']); $i++) {
            $arquivosNormalizados[$i]['name'] = $arquivos['name'][$i];
            $arquivosNormalizados[$i]["full_path"] = $arquivos['full_path'][$i];
            $arquivosNormalizados[$i]["type"] = $arquivos['type'][$i];
            $arquivosNormalizados[$i]["tmp_name"] = $arquivos['tmp_name'][$i];
            $arquivosNormalizados[$i]["error"] = $arquivos['error'][$i];
        }

        return $arquivosNormalizados;
    }
}
