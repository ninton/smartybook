<?xml version="1.0" encoding="utf-8"?>
<smartyIndex>
{foreach from=$data item="topic" name="article"}
{if $topic.category neq "Notice"}
    <entry entryTitle="{$topic.title|escape|strip_tags:false}" entryExcerpt="{$topic.text|escape|strip_tags:false}" entryDate="{$topic.time|date_format:"%Y-%m-%d %H:%M:%S"}" entryPermalink="index.php?category={$topic.category}" />
{/if}
{foreachelse}
    <entry entryTitle="-" entryExcerpt="記事はありません" entryDate="---------- --:--:--" entryPermalink="index.php" />
{/foreach}
</smartyIndex>