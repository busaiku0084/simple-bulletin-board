<?php

define('DATA_FILE', __DIR__ . '/data/messages.txt');

/**
 * 全投稿を読み込む（配列で返す）
 */
function read_messages(): array
{
    if (!file_exists(DATA_FILE)) {
        return [];
    }
    return file(DATA_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

/**
 * 投稿を保存する（追加）
 */
function save_message(string $name, string $message): void
{
    $line = time() . "\t" . $name . "\t" . str_replace(["\r", "\n"], '', $message) . PHP_EOL;
    file_put_contents(DATA_FILE, $line, FILE_APPEND | LOCK_EX);
}

/**
 * 投稿を更新する（上書き）
 */
function update_message(int $id, string $name, string $message): void
{
    $messages = read_messages();
    if (!isset($messages[$id])) return;

    $messages[$id] = time() . "\t" . $name . "\t" . str_replace(["\r", "\n"], '', $message);
    file_put_contents(DATA_FILE, implode(PHP_EOL, $messages) . PHP_EOL);
}

/**
 * 投稿を削除する
 */
function delete_message(int $id): void
{
    $messages = read_messages();
    if (!isset($messages[$id])) return;

    unset($messages[$id]);
    file_put_contents(DATA_FILE, implode(PHP_EOL, $messages) . PHP_EOL);
}
