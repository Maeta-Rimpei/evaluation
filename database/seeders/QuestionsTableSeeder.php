<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // ------------------------------園長、副園長、主任-------------------------
        DB::table('questions')->insert([
            'content' => '法人の理念や園の保育理念に沿って、子供たちの自由を尊重し、自分で考え、自分で決定し、自分で行動できる子供たちを育むことを大切に保育をしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '日頃から「保育所保育指針」をよく読み、その理念を理解したうえで、保育内容や保育方法を考えるときのガイドラインとしている。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '個人情報の保護に配慮し、業務上、職務上知り得た情報や秘密を漏らしていない。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子供は一人の人間であり、独自の存在としての権利を有していることを理解し、子ども一人一人の人格を尊重している。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '就業規則に従い、職員の労働時間や休日・年次有給休暇・休憩等の就業状況を把握し、適正に管理している。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '保育所の課題について職員が共通の理解を深め、協力して改善に努めることができる体制を作るようにしている。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '職員一人一人の専門性の向上の機会を提供し、保育所全体の保育の質の向上に努めている。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '職員の悩みに耳を傾けたり、助言したりする機会を大切にし、職員一人一人に合わせた指導や声かけをするように努めている。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '積極的に研修や講習に参加したり、専門書を読んだり、情報収集等をしたりして、自己研鑽を積んでいる。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '「幼児期の終わりまでに育ってほしい姿10の姿」を目安に、全体計画に基づき、子どもの実態に即した計画を作成するように指導助言している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '月・週・日案などが、実際の子どもの姿、興味・関心にあっていたかという視点から自分の保育を振り返り、評価を行い、保育の改善を図るよう指導助言している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもたちが主体的に考え、動き、話し、遊びを選ぶことができるように、複数の種類の玩具や遊びが選択できる環境を整えるよう指導助言している。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '子どもたちの非認知能力を育むために、教えることではなく、子どもたちが考え、選び、行動し、反省し、さらに工夫していく過程を見守りながら待つことを大切にするよう指導助言している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '要支援児も健常児と等しく、個性を考慮し、尊重しながら、一人一人の子どもの発達過程を理解し把握したうえで、共に成長していくような援助を心がけるよう指導助言している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもの日々の機嫌・食欲・顔色等、心身の状態をきめ細かに観察し、平常とは異なった状態の場合には速やかに対応するよう指導助言している。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '子ども一人一人をよく観察し、遊びや遊具が適切であるかどうか見極め、不足であれば追加し、遊ばなくなった場合は別の遊具と交換するような指導助言している。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '子どもたちが生活と遊びの中で、食にかかわる体験を積み重ね、食事を楽しく・おいしく食べられるように色々な工夫をするような指導助言している。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '子どもの発達の特性と事故との関わりに留意し、日常的な点検、事故報告、ヒヤリハット報告、インシデント報告を行うことによってハザードを減らすよう努めている。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '食物アレルギー児の食事については、主治医の診断書、指示書に基づき、除去食材や調理法を把握し、除去食の誤配や誤植がないよう細心の注意を払っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '地震等の災害や火災に備え、積極的に避難訓練等を実施し、非常災害時に何をしなければならないか理解している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '玩具の破損、施設の不備など安全な環境を保つよう注意を払うとともに、整理・整頓、掃除にも心がけ清潔感のある環境を整えている。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '日頃から保護者の話をよく聞き、コミュニケーションを大切にし、保護者から意見・苦情・要望などが伝えやすい関係づくりに努めている。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '送迎時・連絡帳・保育参加・個人懇談等の機会を活用し、保育の意図や日頃の子どもの様子を保護者にわかりやすく伝え、子どもに関する情報交換を細やかに行うように努めている。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => 'パソコンで、イラストを挿入したお便りを作成することができる。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '電子メールの活用やインターネットを使った情報検索をすることができる。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '施設内に備えてあるワード・エクセルの参考書(500円でわかるワード・エクセル)を読んで操作を理解している。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '昨年から成長したと思う点',
            'category' => '1',
        ]);

        DB::table('questions')->insert([
            'content' => '自己の課題',
            'category' => '1',
        ]);

        DB::table('questions')->insert([
            'content' => '来年度の目標',
            'category' => '1',
        ]);
        
        // ------------------------------保育士、看護師、保育補助員-------------------------

        DB::table('questions')->insert([
            'content' => '法人の理念や園の保育理念に沿って、子供たちの自由を尊重し、自分で考え、自分で決定し、自分で行動できる子供たちを育むことを大切に保育をしている。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '日頃から「保育所保育指針」をよく読み、その理念を理解したうえで、保育内容や保育方法を考えるときのガイドラインとしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '個人情報の保護に配慮し、業務上、職務上知り得た情報や秘密を漏らしていない。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子供は一人の人間であり、独自の存在としての権利を有していることを理解し、子ども一人一人の人格を尊重している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '「幼児期の終わりまでに育ってほしい姿10の姿」を目安に、全体計画に基づき、子どもの実態に即した計画を作成している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '月・週・日案などが、実際の子どもの姿、興味・関心にあっていたかという視点から自分の保育を振り返り、評価を行い、保育の改善を図っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもたちが主体的に考え、動き、話し、遊びを選ぶことができるように、複数の種類の玩具や遊びが選択できる環境を整えている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもたちの非認知能力を育むために、教えることではなく、子どもたちが考え、選び、行動し、反省し、さらに工夫していく過程を見守りながら待つことを大切にしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子ども一人一人をよく観察し、遊びや遊具が適切であるかどうか見極め、不足であれば追加し、遊ばなくなった場合は別の遊具と交換している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '要支援児も健常児と等しく、個性を考慮し、尊重しながら、一人一人の子どもの発達過程を理解し把握したうえで、共に成長していくような援助を心がけている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもたちが生活と遊びの中で、食にかかわる体験を積み重ね、食事を楽しく・おいしく食べられるように色々な工夫をしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもの日々の機嫌・食欲・顔色等、心身の状態をきめ細かに観察し、平常とは異なった状態の場合には速やかに対応している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもの発達の特性と事故との関わりに留意し、日常的な点検、事故報告、ヒヤリハット報告、インシデント報告を行うことによってハザードを減らすよう努めている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '食物アレルギー児の食事については、主治医の診断書、指示書に基づき、除去食材や調理法を把握し、除去食の誤配や誤植がないよう細心の注意を払っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '地震等の災害や火災に備え、積極的に避難訓練等を実施し、非常災害時に何をしなければならないか理解している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '大声を出したり、子どもを怒ったり、脅したり、急がせたり、「こうであるべき」と決めつけたりしないような、子どもへの関わり方をしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもたちが自発的に始めた遊びを見守るとともに、自分自身が子どもたちと一緒に、楽しく、ワクワクした気持ちで過ごしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '日々の保育を通じて自己を振り返るとともに、研修に参加したり専門書を読むなどして、保育に関わる様々な知識や技能の向上に努めている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '玩具の破損、施設の不備など安全な環境を保つよう注意を払うとともに、整理・整頓、掃除にも心がけ清潔感のある環境を整えている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '締切りのある仕事や提出物の締切日、会議や打ち合わせの時間をきちんと守っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '日頃から保護者の話をよく聞き、コミュニケーションを大切にし、保護者から意見・苦情・要望などが伝えやすい関係作りに努めている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '送迎時・連絡帳・保育参加・個人懇談等の機会を活用し、保育の意図や日頃の子どもの様子を保護者に分かりやすく伝え、子どもに関する情報交換を細やかに行うよう努めている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => 'パソコンで、写真やイラストを挿入したお便りを作成することができる。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '電子メールの活用やインターネットを使った情報検索をすることができる。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '施設内に備えてあるワード・エクセルの参考書（500円でわかるワード・エクセル）を読んで操作を理解している。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '昨年から成長したと思う点',
            'category' => '1',
        ]);

        DB::table('questions')->insert([
            'content' => '自己の課題',
            'category' => '1',
        ]);

        DB::table('questions')->insert([
            'content' => '来年度の目標',
            'category' => '1',
        ]);
        
        // -----------------------------事務員、調理員-----------------------------

        DB::table('questions')->insert([
            'content' => '法人の理念や園の保育理念、保育方針に沿って業務ができている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '日頃から「保育所保育指針」を読み、業務のガイドラインとしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '個人情報の保護に配慮し、業務上・職務上知り得た情報や秘密を漏らしていない。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもは一人の人間であり、独自の存在としての権利を有していることを理解し、子ども一人一人の人格を尊重している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもの発達の特性と事故との関わりに留意し、日常的な点検、事故報告、ヒヤリハット報告、インシデント報告を行うことによってハザードを減らすよう努めている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '食物アレルギー児の食事については、主治医の診断書、指示書に基き、除去食材や調理法を把握し、調理中は除去食材が混ざることがないよう細心の注意を払っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '地震等の災害や火災に備え、積極的に避難訓練等に参加し、非常災害時に何をしなければならないか理解している。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '大声を出したり、子どもを怒ったり、脅したり、急がせたり、「こうあるべき」と決めつけたりしないような、子どもへのかかわり方をしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '大量調理施設衛生管理マニュアルに従い、調理室の衛生管理を行っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '大量調理施設衛生管理マニュアルに基づき、仕入、検品、調理、保存等食品管理を行っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '持ち場を離れるときは必ず声を掛けてから離れるようにしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '公私の区別をし、不機嫌な態度でまわりに不快感を与えないようにしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '仕事の効率化を考ながら仕事をしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '電話の応対・来客への対応は、明るく笑顔で丁寧に対応し、不快感を与えないようにしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '研修に参加したり専門書を読むなどして、知識や技能の向上に努めている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '施設・設備の点検、園内外の清掃や整理整頓を行っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '締切りのある仕事や提出物の締切日、会議や打ち合わせの時間をきちんと守っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '必要に応じ、保育に自ら手助けに入っている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '子どもや保護者との対応に,公平さを欠かないようにしている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '日頃から保護者の話をよく聞き、コミュニケーションを大切にし、保護者から意見・苦情・要望などが伝えやすい関係作りに努めている。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '電子メールの活用やインターネットを使った情報検索をすることができる。',
            'category' => '0',
        ]);
        
        DB::table('questions')->insert([
            'content' => '施設内に備えてあるワード・エクセルの参考書（500円でわかるワード・エクセル）を読んで操作を理解している。',
            'category' => '0',
        ]);

        DB::table('questions')->insert([
            'content' => '昨年から成長したと思う点',
            'category' => '1',
        ]);

        DB::table('questions')->insert([
            'content' => '自己の課題',
            'category' => '1',
        ]);

        DB::table('questions')->insert([
            'content' => '来年度の目標',
            'category' => '1',
        ]);
    }
}
