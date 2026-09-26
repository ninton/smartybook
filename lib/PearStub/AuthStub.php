<?php

declare(strict_types=1);

namespace Lib\PearStub;

/**
 * 書籍で Pear/Auth を使っていましたが、Pear/Auth はメンテナンスされていません。
 * 代わりにこのスタブを使用します。
 */
final class AuthStub
{
    /**
     * @var array<string, string> $users ユーザー名とパスワードの配列
     */
    private array $users = [];
    /**
     * @var callable ログイン時に呼び出されるコールバック関数
     */
    private $loginFunction;

    /**
     * @param string $storageDriver 認証情報のストレージドライバー（例: 'Array'）
     * @param array<string, mixed> $options 認証パラメータ（ユーザー情報など）
     * @param callable $loginFunction ログイン時に呼び出されるコールバック関数
     */
    public function __construct(string $storageDriver, array $options, callable $loginFunction)
    {
        if ($storageDriver !== 'Array') {
            throw new \InvalidArgumentException('Unsupported storage driver: ' . $storageDriver);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->users = $options['users'] ?? [];
        $this->loginFunction = $loginFunction;
    }

    public function start(): void
    {
        // ログインフォーム送信の処理
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
            $username = (string)$_POST['username'];
            $password = (string)$_POST['password'];

            // MD5ハッシュ照合（※互換性のため元のMD5ロジックを保持）
            // @fixme md5() を 現代基準の password_verify() に置き換えたい
            if (isset($this->users[$username]) && $this->users[$username] === md5($password)) {
                session_regenerate_id(true);
                $_SESSION['__auth_user'] = $username;
            } else {
                call_user_func($this->loginFunction, $username, -3);
                exit;
            }
        }

        // 未認証時のフォーム表示
        if (!$this->getAuth()) {
            call_user_func($this->loginFunction, '', 0);
            exit;
        }
    }

    public function getAuth(): bool
    {
        return isset($_SESSION['__auth_user']);
    }

    public function logout(): void
    {
        unset($_SESSION['__auth_user']);
    }
}
