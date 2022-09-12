<?php
namespace MCQ\Frontend;

trait Block {
    public function block_init() {
        register_block_type( __DIR__ . '/mcq/build' );
    }
}
