<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('featured_image')->nullable();
            $table->timestamps();
        });
    }
    
// 3. Posts Table

// Create a posts table that stores blog posts with the following columns:

// id: Primary key.

// title: Title of the blog post.

// content: Main content of the post (use text type).

// category_id: Foreign key referencing id in the categories table.

// On category deletion, related posts should also be deleted (onDelete('cascade')).

// user_id: Foreign key referencing id in the users table.

// On user deletion, related posts should also be deleted (onDelete('cascade')).

// featured_image: Stores the image path or URL (nullable).

// timestamps: Includes created_at and updated_at.

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
