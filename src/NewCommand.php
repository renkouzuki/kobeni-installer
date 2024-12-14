<?php

namespace Kobeni\Installer;

class NewCommand
{
    protected $directory;

    public function run(array $argv)
    {
        // Get project name from command line
        $this->directory = $argv[1] ?? null;

        if (!$this->directory) {
            echo "Please provide a project name.\n";
            echo "Usage: kobeni new project-name\n";
            exit(1);
        }

        $this->ensureDirectoryDoesNotExist();
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
        passthru("git clone https://github.com/your-username/kobeni-framework {$this->directory}");
        
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