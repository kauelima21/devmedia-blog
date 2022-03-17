<?php
namespace Source\Core;

class View
{
    public function __construct(private string $path)
    {
        $this->path = $path;
    }

    private function getViewContent(string $fileName)
    {
        $file = $this->path . (substr($fileName, 0) == "/" ? $fileName : "/" . $fileName) . ".html";

        if (! is_file($file) && ! file_exists($file)) {
            throw new \Exception("Arquivo invalido. A view nao pode ser encontrada!");
        }

        $viewContent = file_get_contents($file);
        return $viewContent;
    }

    public function render(string $view, array $data)
    {
        $view = $this->getViewContent($view);
        $keys = array_keys($data);
        $keys = array_map(fn($value) => "{{" . $value . "}}", $keys);
        return str_replace($keys, array_values($data), $view);
    }
}
