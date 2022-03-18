<?php
namespace Source\Core;

class View
{
    public function __construct(private string $path)
    {
        $this->path = $path;
    }

    public function render(string $view, array $data)
    {
        $view = $this->getViewContent($view);
        $keys = array_keys($data);
        $keys = array_map(fn ($value) => '{{' . $value . '}}', $keys);

        /**
         * A heranca se da pela syntax reservada @arquivo.html@
         */
        if (preg_match('/^@(.*)@/', $view, $matchs)) {
            $view = substr($view, strlen($matchs[0]));
            $view = $this->getFatherView($matchs[1], $view);
        }
        return str_replace($keys, array_values($data), $view);
    }

    private function getViewContent(string $fileName)
    {
        $file = $this->path . (substr($fileName, 0) == '/' ? $fileName : '/' . $fileName);

        if (!is_file($file) && !file_exists($file)) {
            throw new \Exception('Arquivo invalido. A view nao pode ser encontrada!');
        }

        $viewContent = file_get_contents($file);
        return $viewContent;
    }

    private function getFatherView($fatherView, $view)
    {
        $fatherView = $this->getViewContent($fatherView);
        if (! strpos($fatherView, "{{content}}")) {
            throw new \Exception('Views pai precisam de um "{{content}}"');
        }
        return str_replace('{{content}}', $view, $fatherView);
    }
}
