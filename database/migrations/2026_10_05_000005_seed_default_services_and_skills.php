<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void
    {
        $now = now();
        foreach ([['name'=>'Full-stack web development','slug'=>'full-stack-web-development'],['name'=>'Laravel development','slug'=>'laravel-development'],['name'=>'Responsive web design','slug'=>'responsive-web-design'],['name'=>'WordPress websites','slug'=>'wordpress-websites'],['name'=>'SEO optimisation','slug'=>'seo-optimisation'],['name'=>'Performance improvements','slug'=>'performance-improvements']] as $item) { DB::table('portfolio_services')->insert(['name'=>$item['name'],'slug'=>$item['slug'],'intro'=>'Professional service for modern websites and digital products.','details'=>'A practical service focused on useful outcomes, clear communication and maintainable work.','points'=>json_encode(['Clear scope','Responsive delivery','Useful handover']),'published'=>1,'created_at'=>$now,'updated_at'=>$now]); }
        foreach ([['name'=>'HTML5','slug'=>'html5','category'=>'Frontend'],['name'=>'CSS3','slug'=>'css3','category'=>'Frontend'],['name'=>'JavaScript','slug'=>'javascript','category'=>'Frontend'],['name'=>'PHP','slug'=>'php','category'=>'Backend'],['name'=>'Laravel','slug'=>'laravel','category'=>'Backend'],['name'=>'SEO','slug'=>'seo','category'=>'Digital marketing']] as $item) { DB::table('portfolio_skills')->insert(['name'=>$item['name'],'slug'=>$item['slug'],'category'=>$item['category'],'intro'=>'A practical skill in the portfolio toolkit.','details'=>'Used thoughtfully as part of accessible, maintainable and useful web experiences.','points'=>json_encode(['Practical project use','Continuous learning','Clean implementation']),'published'=>1,'created_at'=>$now,'updated_at'=>$now]); }
    }
    public function down(): void { DB::table('portfolio_services')->truncate(); DB::table('portfolio_skills')->truncate(); }
};
