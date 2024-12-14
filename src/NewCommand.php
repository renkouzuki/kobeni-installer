<?php

namespace Kobeni\Installer;

class NewCommand
{
    protected $directory;

    public function run(array $argv)
    {
        // Check if we have the "new" command and a project name
        if (!isset($argv[1]) || $argv[1] !== 'new' || !isset($argv[2])) {
            echo "Please use the format: php kobeni new project-name\n";
            exit(1);
        }

        $this->directory = $argv[2];

        if (is_dir($this->directory)) {
            echo "Project directory already exists.\n";
            exit(1);
        }

        $this->download();
        $this->configure();
        $this->finish();
    }

    protected function ensureDirectoryDoesNotExist()
    {
        if (is_dir($this->directory)) {
            echo "Project directory already exists.\n";
            exit(1);
        }
    }

    protected function download()
    {
        echo "Creating new Kobeni Framework project...\n";
        // Clone your framework repository
        passthru("git clone https://github.com/renkouzuki/Kobeni-Framework {$this->directory}");

        echo "Installing dependencies...\n";
        passthru("cd {$this->directory} && composer install");
    }

    protected function configure()
    {
        // Copy .env.example to .env if it exists
        if (file_exists("{$this->directory}/.env.example")) {
            copy(
                "{$this->directory}/.env.example",
                "{$this->directory}/.env"
            );
        }
    }

    protected function finish()
    {
        echo "\nKobeni Framework installed successfully!\n";
        echo "Get started with:\n\n";
        echo "  cd {$this->directory}\n";
        echo "  php kobeni start\n";
    }
}
