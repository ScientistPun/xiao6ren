<?php
namespace scientistpun\xiao6ren;

use com\nlf\calendar\Lunar;
use com\nlf\calendar\LunarTime;
use com\nlf\calendar\Solar;

class Xiao6Ren {
    // 卦象
    private static $GUAXIANG = ['大安', '留连', '速喜', '赤口', '小吉', '空亡'];
    // 凶吉
    private static $GUAXIANGXJ = [1, 0, 1, 0, 1, 0];
    // 卦辞
    private static $GUACI = [
        '大安事事昌，安康；求财在坤方，西南方；失物去不远；宅舍保安康；行人身未动；病者主无妨；将军回田野；仔细兴推祥',
        '留连事难成；延迟、拖延、阻碍；求谋日未明；不明确时间；官事只宜缓；去者来回程；失物南方去；急寻方心明；更需防口舌；人事且平平',
        '速喜喜来临；求财向南行；失物申未午；方向：南方、西南方；逢人要打听；官事有福德；病者无须恐；田宅六畜吉；行人音信明',
        '赤口主口舌；官非切要防；失物急去寻；行人有惊慌；鸡犬多作怪；病者出西方；更须防咀咒；恐怕染瘟殃',
        '小吉最吉昌；路上好商量；阴人来报喜；失物在坤方，西南方；行人立便至；交易甚是强；凡是皆和合；病者祈上苍',
        '空亡事不祥；阴人多乖张；求财无利益；行人有灾秧；失物寻不见；官事有刑伤；病人逢暗鬼；析解可安康',
    ];

    // 口诀
    private static $KOUJUE = [
        '大安事事昌，求财在坤方；失物去不远，宅舍保安康；行人身未动，病者主无妨；将军回田野，仔细与推详；丢失在附近，可能西南向；安居得吉日，不可动身祥；办事别出屋，求借邀自房；得病凶化吉，久疾得安康；寻人知音信，可能归村庄；口舌能消散，远行要提防；交易别出村，离屯细推详；求财有八分，得全不出房',
        '留连事未当，求事日莫光；凡事只宜缓，去者未回向；失物南方去，急急行便访；紧记防口舌，人口且平祥；丢失难寻找，窃者又转场；出行定不归，久去拖延长；办事不果断，牵连又返往；求借不易成，被求而彷徨；此日患疾病，几天不复康；找人迷雾中，迷迷又恍惚；口舌继续有，拖拉又伸长；女方嫁吉日，求财六分量',
        '速喜喜临乡，求财往南方；失物申午未，逢人路寻详；官事有福德，病者无大伤；六畜田稼庆，行人有音向；丢失得音信，微乐在面上；出行遇吉利，小喜而顺当；办事如逢春，吉利又荣光；小量可求借，大事难全强；久病见小愈，得病速回康；寻人得知见，口舌见消亡；交易可得成，但不太久长；求财有十分，吉时得顺当',
        '赤口主口伤，官事且紧防；失物急去找，行人有惊慌；鸡犬多作怪，病者上西方；更须防咒咀，恐怕染瘟殃；找物犯谎口，寻问无音向；出门千口怨，言谈万骂伤；办事犯口舌，难成有阻挡；求借不全顺，闭口无事张；得病千口猜，求医还无妨；寻人得凶音，人心不安详；口舌犯最重，交易口舌防；求财只四分，逢吉才成当',
        '小吉最吉昌，路上好商量；阴人来报喜，失物在坤方；行人立刻至，交易甚是强；凡事皆合好，病者保安康；大吉又大顺，万事如意详；出行可得喜，千里吉安详；诸事可心顺，有忧皆消光；求借自来助，众友愿相帮；重病莫要愁，久病得安康；不见得相见，不打自归庄；千人称赞君，无限上荣光；交易成兴隆，十二分财量',
        '空亡事不长，阴人无主张；求财心白费，行人有灾殃；失物永不见，官事有刑伤；病人遇邪鬼，久病添祸殃；失物难找见，找寻空荡荡；出行不吉利，凶多不吉祥；办事凶为多，处处有阻挡；求借不能成，成事化败伤；得病凶多噩，久患雪加霜；寻人无音信，知音变空想；万口都诽骂，小舟遭狂浪；求财有二分，不吉不利亡',
    ];
    // 解卦
    private static $JIEGUA = [
        '卜到大安，属吉卦，凡事都可以得到安康，但是此为静卦，宜静不宜动',
        '卜到留连，属凶卦，代表凡事阻碍、迟滞，此卦更不宜有过大动作，凡事宜守',
        '卜到速喜为吉卦，代表凡事皆有喜讯，而且很快就会到来',
        '卜到赤口为凶卦，代表运势多舛，而且诸多纷争亦有口舌之祸',
        '卜到小吉为吉卦，代表凡事皆吉，但是不如大安的安稳也不如速喜快速，而是介于两者中间',
        '卜到空亡为凶卦，代表凡事秽暗不明，内心不安，运途起伏',
    ];

    private static $SHUOMING = [
        '主木。身不动时，五行属木，颜色青色，方位东方。临青龙，谋事主一、五、七。有静止、心安。吉祥之含义。',
        '主水。人未归时，五行属水，颜色黑色，方位北方，临玄武，凡谋事主二、八、十。有喑味不明，延迟。纠缠．拖延、漫长之含义。',
        '主火。人即至时，五行属火，颜色红色，方位南方，临朱雀，谋事主三，六，九。有快速、喜庆，吉利之含义。指时机已到。',
        '主金。官事凶时，五行属金，颜色白色，方位西方，临白虎，谋事主四、七，十。有不吉、惊恐，凶险、口舌是非之含义。',
        '主木。人来喜时，五行属木，临六合，凡谋事主一、五、七有和合、吉利之含义。',
        '主土。音信稀时，五行属土，颜色黄色，方位中央；临勾陈。谋事主三、六、九。有不吉、无结果、忧虑之含义。',
    ];

    private static $YUNSHI = [
        '目前运势还不错，有稳定成长的情况，但不宜躁进。',
        '目前运势低迷，心情不开朗，凡事受阻',
        '目前运势渐开，要积极的行动就可以如愿',
        '目前运势不明，若有大计划就要赶快实施、不要拖延，则可成功。若卜小事则不成',
        '目前运势不错，保持目前状况就会越来越好',
        '目前运势不佳，自身拿不定主意，无所适从，可多听取他人之意见，切莫随意就做判断',
    ];

    private static $CAIFU = [
        '求财可，但是目前不宜扩张，只能够守住旧业。',
        '求财不可得，此为破财之卦，且有被人影响破财之现象',
        '求财可得，但有先破财而后得财或者先得财后破财之兆，若得到钱财就必须赶快脱身',
        '大起大落之财，求财不易',
        '求财可得，而且有因人得财之兆',
        '求财难得，保守为要',
    ];

    private static $GANQING = [
        '女子感情顺遂，男子感情较差。感情虽稳，但是以无新鲜感，会出现点小问题。',
        '双方沟通不良、冷战、或者一方过于强势，感情不得平衡',
        '若是刚开始的感情，则为热恋。若是已经持续一段时间，则为口舌',
        '感情纷争多，或女方身体有疾病',
        '若没有感情，则可因他人介绍而得。若有感情，则恋情顺利',
        '双方争执多，且有因他人问题或者介入而争执之事',
    ];

    private static $CAREER = [
        '目前工作稳定，可得上司赏识，但切勿锋芒太露',
        '被上司盯或者被人扯后腿，小人之卦',
        '工作得利，但须注意文件上的疏失',
        '若为武职或者粗重行业则顺，若为文职则不顺',
        '工作不错，但须注意处理公司财务之事，以及与下属沟通之事',
        '工作失利，容易被人陷害或者暗中耳语，或者因他人问题而让自己工作失利',
    ];

    private static $HEALTH = [
        '身体没有大病，但须注意病由口入，或因过度操劳而得病',
        '肠胃不舒服或者精神压力太大所得之病',
        '心脏、血液循环有问题或者头部、脑压的问题，但是问题不大',
        '胸口、支气管，或者有血光之灾，且赤口也有流行疾病的意义',
        '肝胆之疾病和消化系统，但是问题不大',
        '脾胃出毛病，或者神经系统出问题，也有因灵界而生病之兆',
    ];

    private static $XINGREN = [
        '人平安，但目前不愿与自身联络',
        '人平安，但目前仍流连忘返',
        '人已经快到了',
        '所问之人目前有困难或者有事情纠缠',
        '人已经快到了',
        '人在途中遇到困难或灾厄而难到',
    ];

    private static $ONTHEDAY = [
        ['大安加大安，事事平安，无需操心，但多有停滞，难求进展', '大安加留连，办事不周全，失物西北去，婚姻晚几天。', '大安加速喜，事事自己起，失物当日见，婚姻自己提。', '大安加赤口，办事不顺手，失物不用找，婚姻两分手。', '大安加小吉，事事从己及，失物不出门，婚姻成就地。', '大安加空亡，病人要上床，失物无踪影，事事不顺情。'],
        ['留连加大安，办事两分张，婚姻有喜事，先苦后来甜。', '留连加留连，事不明晰，有拖延之象，难以快速解决', '留连加速喜，事事由自己，婚姻有成意，失物三天里。', '留连加赤口，病者死人口，失物准丢失，婚姻两分手。', '留连加小吉，事事不用提，失物东南去，病者出人齐。', '留连加空亡，病人准死亡，失物不见面，婚姻两分张。'], 
        ['速喜加大安，事事都平安，姻姻成全了，占病都相安。', '速喜加留连，婚姻不可言，失物无信息，病人有仙缘。', '速喜加速喜，一切顺利，宜行动，多见成功', '速喜加赤口，自己往外走，失物往正北，婚姻得勤走。', '速喜加小吉，婚姻有人提，病人当天好，时物在家里。', '速喜加空亡，婚姻有分张，病者积极治，失物不久见。'],
        ['赤口加大安，办事险和难，失物东北找，婚姻指定难。', '赤口加留连，办事有困难，行人在外走，失物不回还。', '赤口加速喜，婚姻在自己，失物有着落，办事官事起。', '赤口加赤口，口舌至深，慎防冲突，有官非之险', '赤口加小吉，办事自己提，婚姻不能成，失物无信息。', '赤口加空亡，无病也上床，失物不用找，婚姻不能成。'],
        ['小吉加大安，事事两周全，婚姻当日定，失物自己损。', '小吉加留连，事事有反还，婚姻有人破，失物上西南。', '小吉加速喜，事事从头起，婚姻能成就，失物在院里。', '小吉加赤口，办事往外走，婚姻有难处，失物丢了手。', '小吉加小吉，好事成双，大吉之兆', '小吉加空亡，病人不妥当，失物正东找，婚姻再想想。'],
        ['空亡加大安，事事不周全，婚姻从和好，失物反复间。', '空亡加留连，办事处处难，婚姻重新定，失物永不还。', '空亡加速喜，事事怨自己，婚姻有一定，失物在家里。', '空亡加赤口，办事官非有，婚姻难定准，失物往远走。', '空亡加小吉，事事有猜疑，婚姻有喜事，失物回家里。', '空亡加空亡大凶之兆，无结果，徒劳无功']
    ];

    /**
     * @var Lunar
     */
    private static $lunar = null;
    /**
     * @var LunarTime
     */
    private static $lunarTime = null;
    private static $guaNum = -1;
    private static $dayGuaNum = -1;

    private function __construct($lunarYear, $lunarMonth, $lunarDay, $hour) {
        $lunarTime = LunarTime::fromYmdHms($lunarYear, $lunarMonth, $lunarDay, $hour, 1, 0);
        
        $lunar = Lunar::fromYmd($lunarYear, $lunarMonth, $lunarDay);
        $monthZhi = $lunar->getMonthZhiIndex();
        $dayZhi = $lunar->getDayZhiIndex();
        $hourZhi = $lunarTime->getZhiIndex();

        $this->lunar = $lunar;
        $this->lunarTime = $lunarTime;
        $this->guaNum = ($monthZhi + $dayZhi) % 6;
        $this->dayGuaNum = ($monthZhi + $dayZhi + $hourZhi) % 6;
    } 


    public static function fromYmdH($year, $month, $day, $hour) {
        $solar = Solar::fromYmdHms($year, $month, $day, $hour, 1, 0);
        $lunar = $solar->getLunar();
        return new X6R($lunar->getYear(), $lunar->getMonth(), $lunar->getDay(), $hour);
    }

    public function getGuaXiang() {
        return self::$GUAXIANG[$this->guaNum];
    }

    public function getGuaCi() {
        return self::$GUACI[$this->guaNum];
    }

    public function getXjType() {
        return self::$GUAXIANGXJ[$this->guaNum] == 1;
    }

    public function getXj() {
        return self::$GUAXIANGXJ[$this->guaNum] == 1 ? '吉':'凶';
    }

    public function getJieGua() {
        return self::$JIEGUA[$this->guaNum];
    }

    public function getKouJue() {
        return self::$KOUJUE[$this->guaNum];
    }

    public function getShuoMing() {
        return self::$SHUOMING[$this->guaNum];
    }

    public function getTheDay() {
        return self::$ONTHEDAY[$this->guaNum][$this->dayGuaNum];
    }

    public function getYunShi() {
        return self::$YUNSHI[$this->guaNum];
    }

    public function getGanQing() {
        return self::$GANQING[$this->guaNum];
    }

    public function getCareer() {
        return self::$CAREER[$this->guaNum];
    }

    public function getCaiFu() {
        return self::$CAIFU[$this->guaNum];
    }

    public function getHealth() {
        return self::$HEALTH[$this->guaNum];
    }

    public function getXingRen() {
        return self::$XINGREN[$this->guaNum];
    }

    public function getGanZhi() {
        return [
            'year' => $this->lunar->getYearInGanZhi(),
            'month' => $this->lunar->getMonthInGanZhi(),
            'day' => $this->lunar->getDayInGanZhi(),
            'hour' => $this->lunarTime->getGanZhi()
        ];
    }

    public function getFullData() {
        return [
            '卦象' => $this->getGuaXiang(),
            '卦辞' => $this->getGuaCi(),
            // '口诀' => $this->getKouJue(),
            '吉凶' => $this->getXj(),
            '解卦' => $this->getJieGua(),
            '运势' => $this->getYunShi(),
            '感情' => $this->getGanQing(),
            '事业' => $this->getCareer(),
            '财运' => $this->getCaiFu(),
            '健康' => $this->getHealth(),
            '行人' => $this->getXingRen(),
            '日加时断' => $this->getTheDay(),
        ];
    }
}
