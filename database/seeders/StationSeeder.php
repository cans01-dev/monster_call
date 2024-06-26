<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = [
            [1, 1, '090100'],
            [2, 2, '090101'],
            [3, 3, '090102'],
            [4, 4, '090103'],
            [5, 4, '090104'],
            [6, 4, '090105'],
            [7, 5, '090106'],
            [8, 3, '090107'],
            [9, 6, '090108'],
            [10, 7, '090109'],
            [11, 8, '090110'],
            [12, 4, '090111'],
            [13, 4, '090112'],
            [14, 3, '090113'],
            [15, 3, '090114'],
            [16, 3, '090115'],
            [17, 6, '090116'],
            [18, 9, '090117'],
            [19, 2, '090118'],
            [20, 6, '090119'],
            [21, 10, '090120'],
            [22, 10, '090121'],
            [23, 3, '090122'],
            [24, 7, '090123'],
            [25, 3, '090124'],
            [26, 10, '090125'],
            [27, 10, '090126'],
            [28, 7, '090127'],
            [29, 7, '090128'],
            [30, 7, '090129'],
            [31, 11, '090130'],
            [32, 12, '090131'],
            [33, 1, '090132'],
            [34, 2, '090133'],
            [35, 6, '090134'],
            [36, 2, '090135'],
            [37, 6, '090136'],
            [38, 5, '090137'],
            [39, 11, '090138'],
            [40, 5, '090139'],
            [41, 4, '090140'],
            [42, 7, '090141'],
            [43, 4, '090142'],
            [44, 4, '090143'],
            [45, 3, '090144'],
            [46, 4, '090145'],
            [47, 4, '090146'],
            [48, 7, '090147'],
            [49, 3, '090148'],
            [50, 5, '090149'],
            [51, 4, '090150'],
            [52, 6, '090151'],
            [53, 11, '090152'],
            [54, 4, '090153'],
            [55, 4, '090154'],
            [56, 4, '090155'],
            [57, 7, '090156'],
            [58, 1, '090157'],
            [59, 3, '090158'],
            [60, 3, '090159'],
            [61, 4, '090160'],
            [62, 4, '090161'],
            [63, 7, '090162'],
            [64, 12, '090163'],
            [65, 11, '090164'],
            [66, 4, '090165'],
            [67, 4, '090166'],
            [68, 3, '090167'],
            [69, 2, '090168'],
            [70, 4, '090169'],
            [71, 10, '090170'],
            [72, 3, '090171'],
            [73, 7, '090172'],
            [74, 10, '090173'],
            [75, 7, '090174'],
            [76, 7, '090175'],
            [77, 10, '090176'],
            [78, 10, '090177'],
            [79, 7, '090178'],
            [80, 7, '090179'],
            [81, 13, '090180'],
            [82, 13, '090181'],
            [83, 7, '090182'],
            [84, 8, '090183'],
            [85, 13, '090184'],
            [86, 13, '090185'],
            [87, 8, '090186'],
            [88, 6, '090187'],
            [89, 4, '090188'],
            [90, 3, '090189'],
            [91, 3, '090190'],
            [92, 3, '090191'],
            [93, 6, '090192'],
            [94, 5, '090193'],
            [95, 14, '090194'],
            [96, 3, '090195'],
            [97, 3, '090196'],
            [98, 6, '090197'],
            [99, 7, '090198'],
            [100, 4, '090199'],
            [101, 2, '090200'],
            [102, 3, '090201'],
            [103, 5, '090202'],
            [104, 12, '090203'],
            [105, 3, '090204'],
            [106, 11, '090205'],
            [107, 3, '090206'],
            [108, 15, '090207'],
            [109, 6, '090208'],
            [110, 16, '090209'],
            [111, 3, '090210'],
            [112, 3, '090211'],
            [113, 12, '090212'],
            [114, 7, '090213'],
            [115, 4, '090214'],
            [116, 4, '090215'],
            [117, 4, '090216'],
            [118, 4, '090217'],
            [119, 7, '090218'],
            [120, 3, '090219'],
            [121, 4, '090220'],
            [122, 4, '090221'],
            [123, 4, '090222'],
            [124, 4, '090223'],
            [125, 4, '090224'],
            [126, 4, '090225'],
            [127, 7, '090226'],
            [128, 5, '090227'],
            [129, 3, '090228'],
            [130, 2, '090229'],
            [131, 4, '090230'],
            [132, 4, '090231'],
            [133, 4, '090232'],
            [134, 4, '090233'],
            [135, 7, '090234'],
            [136, 3, '090235'],
            [137, 5, '090236'],
            [138, 12, '090237'],
            [139, 3, '090238'],
            [140, 6, '090239'],
            [141, 4, '090240'],
            [142, 4, '090241'],
            [143, 4, '090242'],
            [144, 4, '090243'],
            [145, 4, '090244'],
            [146, 4, '090245'],
            [147, 4, '090246'],
            [148, 4, '090247'],
            [149, 4, '090248'],
            [150, 4, '090249'],
            [151, 6, '090250'],
            [152, 6, '090251'],
            [153, 4, '090252'],
            [154, 4, '090253'],
            [155, 4, '090254'],
            [156, 4, '090255'],
            [157, 4, '090256'],
            [158, 7, '090257'],
            [159, 6, '090258'],
            [160, 3, '090259'],
            [161, 5, '090260'],
            [162, 7, '090261'],
            [163, 4, '090262'],
            [164, 4, '090263'],
            [165, 4, '090264'],
            [166, 4, '090265'],
            [167, 4, '090266'],
            [168, 4, '090267'],
            [169, 7, '090268'],
            [170, 11, '090269'],
            [171, 3, '090270'],
            [172, 6, '090271'],
            [173, 4, '090272'],
            [174, 4, '090273'],
            [175, 4, '090274'],
            [176, 4, '090275'],
            [177, 4, '090276'],
            [178, 7, '090277'],
            [179, 1, '090278'],
            [180, 5, '090279'],
            [181, 2, '090280'],
            [182, 11, '090281'],
            [183, 1, '090282'],
            [184, 12, '090283'],
            [185, 5, '090284'],
            [186, 6, '090285'],
            [187, 2, '090286'],
            [188, 11, '090287'],
            [189, 5, '090288'],
            [190, 1, '090289'],
            [191, 10, '090290'],
            [192, 10, '090291'],
            [193, 7, '090292'],
            [194, 13, '090293'],
            [195, 8, '090294'],
            [196, 5, '090295'],
            [197, 6, '090296'],
            [198, 5, '090297'],
            [199, 5, '090298'],
            [200, 5, '090299'],
            [201, 4, '090300'],
            [202, 15, '090301'],
            [203, 4, '090302'],
            [204, 3, '090303'],
            [205, 4, '090304'],
            [206, 3, '090305'],
            [207, 4, '090306'],
            [208, 6, '090307'],
            [209, 4, '090308'],
            [210, 4, '090309'],
            [211, 4, '090310'],
            [212, 11, '090311'],
            [213, 5, '090312'],
            [214, 4, '090313'],
            [215, 4, '090314'],
            [216, 17, '090315'],
            [217, 3, '090316'],
            [218, 2, '090317'],
            [219, 1, '090318'],
            [220, 6, '090319'],
            [221, 4, '090320'],
            [222, 4, '090321'],
            [223, 4, '090322'],
            [224, 4, '090323'],
            [225, 4, '090324'],
            [226, 7, '090325'],
            [227, 3, '090326'],
            [228, 3, '090327'],
            [229, 3, '090328'],
            [230, 12, '090329'],
            [231, 7, '090330'],
            [232, 4, '090331'],
            [233, 6, '090332'],
            [234, 4, '090333'],
            [235, 4, '090334'],
            [236, 3, '090335'],
            [237, 5, '090336'],
            [238, 2, '090337'],
            [239, 7, '090338'],
            [240, 11, '090339'],
            [241, 4, '090340'],
            [242, 6, '090341'],
            [243, 18, '090342'],
            [244, 13, '090343'],
            [245, 7, '090344'],
            [246, 8, '090345'],
            [247, 1, '090346'],
            [248, 4, '090347'],
            [249, 19, '090348'],
            [250, 20, '090349'],
            [251, 13, '090350'],
            [252, 13, '090351'],
            [253, 13, '090352'],
            [254, 13, '090353'],
            [255, 13, '090354'],
            [256, 7, '090355'],
            [257, 7, '090356'],
            [258, 8, '090357'],
            [259, 7, '090358'],
            [260, 13, '090359'],
            [261, 6, '090360'],
            [262, 3, '090361'],
            [263, 3, '090362'],
            [264, 2, '090363'],
            [265, 5, '090364'],
            [266, 3, '090365'],
            [267, 6, '090366'],
            [268, 3, '090367'],
            [269, 13, '090368'],
            [270, 13, '090369'],
            [271, 3, '090370'],
            [272, 3, '090371'],
            [273, 3, '090372'],
            [274, 6, '090373'],
            [275, 2, '090374'],
            [276, 5, '090375'],
            [277, 12, '090376'],
            [278, 11, '090377'],
            [279, 1, '090378'],
            [280, 14, '090379'],
            [281, 10, '090380'],
            [282, 10, '090381'],
            [283, 3, '090382'],
            [284, 7, '090383'],
            [285, 3, '090384'],
            [286, 19, '090385'],
            [287, 3, '090386'],
            [288, 21, '090387'],
            [289, 22, '090388'],
            [290, 23, '090389'],
            [291, 10, '090390'],
            [292, 10, '090391'],
            [293, 3, '090392'],
            [294, 7, '090393'],
            [295, 3, '090394'],
            [296, 7, '090395'],
            [297, 21, '090396'],
            [298, 3, '090397'],
            [299, 24, '090398'],
            [300, 3, '090399'],
            [301, 4, '090400'],
            [302, 4, '090401'],
            [303, 4, '090402'],
            [304, 3, '090403'],
            [305, 5, '090404'],
            [306, 4, '090405'],
            [307, 4, '090406'],
            [308, 4, '090407'],
            [309, 7, '090408'],
            [310, 4, '090409'],
            [311, 2, '090410'],
            [312, 7, '090411'],
            [313, 4, '090412'],
            [314, 4, '090413'],
            [315, 2, '090414'],
            [316, 7, '090415'],
            [317, 8, '090416'],
            [318, 13, '090417'],
            [319, 7, '090418'],
            [320, 7, '090419'],
            [321, 13, '090420'],
            [322, 7, '090421'],
            [323, 8, '090422'],
            [324, 7, '090423'],
            [325, 13, '090424'],
            [326, 7, '090425'],
            [327, 7, '090426'],
            [328, 3, '090427'],
            [329, 3, '090428'],
            [330, 3, '090429'],
            [331, 3, '090430'],
            [332, 5, '090431'],
            [333, 12, '090432'],
            [334, 2, '090433'],
            [335, 6, '090434'],
            [336, 6, '090435'],
            [337, 4, '090436'],
            [338, 4, '090437'],
            [339, 4, '090438'],
            [340, 4, '090439'],
            [341, 7, '090440'],
            [342, 10, '090441'],
            [343, 13, '090442'],
            [344, 13, '090443'],
            [345, 7, '090444'],
            [346, 13, '090445'],
            [347, 7, '090446'],
            [348, 14, '090447'],
            [349, 6, '090448'],
            [350, 3, '090449'],
            [351, 1, '090450'],
            [352, 6, '090451'],
            [353, 4, '090452'],
            [354, 4, '090453'],
            [355, 4, '090454'],
            [356, 5, '090455'],
            [357, 3, '090456'],
            [358, 2, '090457'],
            [359, 6, '090458'],
            [360, 4, '090459'],
            [361, 4, '090460'],
            [362, 4, '090461'],
            [363, 4, '090462'],
            [364, 5, '090463'],
            [365, 3, '090464'],
            [366, 2, '090465'],
            [367, 4, '090466'],
            [368, 4, '090467'],
            [369, 12, '090468'],
            [370, 2, '090469'],
            [371, 4, '090470'],
            [372, 4, '090471'],
            [373, 4, '090472'],
            [374, 4, '090473'],
            [375, 4, '090474'],
            [376, 4, '090475'],
            [377, 3, '090476'],
            [378, 6, '090477'],
            [379, 1, '090478'],
            [380, 7, '090479'],
            [381, 2, '090480'],
            [382, 4, '090481'],
            [383, 4, '090482'],
            [384, 4, '090483'],
            [385, 4, '090484'],
            [386, 7, '090485'],
            [387, 7, '090486'],
            [388, 11, '090487'],
            [389, 5, '090488'],
            [390, 2, '090489'],
            [391, 3, '090490'],
            [392, 4, '090491'],
            [393, 4, '090492'],
            [394, 4, '090493'],
            [395, 4, '090494'],
            [396, 4, '090495'],
            [397, 4, '090496'],
            [398, 1, '090497'],
            [399, 6, '090498'],
            [400, 6, '090499'],
            [401, 7, '090500'],
            [402, 3, '090501'],
            [403, 6, '090502'],
            [404, 7, '090503'],
            [405, 3, '090504'],
            [406, 3, '090505'],
            [407, 3, '090506'],
            [408, 11, '090507'],
            [409, 6, '090508'],
            [410, 3, '090509'],
            [411, 7, '090510'],
            [412, 7, '090511'],
            [413, 3, '090512'],
            [414, 3, '090513'],
            [415, 1, '090514'],
            [416, 3, '090515'],
            [417, 3, '090516'],
            [418, 12, '090517'],
            [419, 5, '090518'],
            [420, 4, '090519'],
            [421, 4, '090520'],
            [422, 4, '090521'],
            [423, 11, '090522'],
            [424, 5, '090523'],
            [425, 3, '090524'],
            [426, 3, '090525'],
            [427, 2, '090526'],
            [428, 1, '090527'],
            [429, 6, '090528'],
            [430, 6, '090529'],
            [431, 4, '090530'],
            [432, 4, '090531'],
            [433, 4, '090532'],
            [434, 4, '090533'],
            [435, 4, '090534'],
            [436, 5, '090535'],
            [437, 3, '090536'],
            [438, 2, '090537'],
            [439, 6, '090538'],
            [440, 4, '090539'],
            [441, 4, '090540'],
            [442, 4, '090541'],
            [443, 4, '090542'],
            [444, 4, '090543'],
            [445, 4, '090544'],
            [446, 7, '090545'],
            [447, 3, '090546'],
            [448, 6, '090547'],
            [449, 6, '090548'],
            [450, 4, '090549'],
            [451, 4, '090550'],
            [452, 4, '090551'],
            [453, 4, '090552'],
            [454, 4, '090553'],
            [455, 4, '090554'],
            [456, 4, '090555'],
            [457, 4, '090556'],
            [458, 4, '090557'],
            [459, 4, '090558'],
            [460, 5, '090559'],
            [461, 7, '090560'],
            [462, 7, '090561'],
            [463, 7, '090562'],
            [464, 7, '090563'],
            [465, 3, '090564'],
            [466, 3, '090565'],
            [467, 3, '090566'],
            [468, 3, '090567'],
            [469, 12, '090568'],
            [470, 2, '090569'],
            [471, 2, '090570'],
            [472, 1, '090571'],
            [473, 6, '090572'],
            [474, 6, '090573'],
            [475, 6, '090574'],
            [476, 4, '090575'],
            [477, 4, '090576'],
            [478, 4, '090577'],
            [479, 4, '090578'],
            [480, 4, '090579'],
            [481, 4, '090580'],
            [482, 4, '090581'],
            [483, 4, '090582'],
            [484, 5, '090583'],
            [485, 5, '090584'],
            [486, 7, '090585'],
            [487, 7, '090586'],
            [488, 7, '090587'],
            [489, 3, '090588'],
            [490, 3, '090589'],
            [491, 3, '090590'],
            [492, 2, '090591'],
            [493, 4, '090592'],
            [494, 4, '090593'],
            [495, 4, '090594'],
            [496, 11, '090595'],
            [497, 3, '090596'],
            [498, 3, '090597'],
            [499, 11, '090598'],
            [500, 4, '090599'],
            [501, 11, '090669'],
            [502, 7, '090676'],
            [503, 6, '090677'],
            [504, 5, '090678'],
            [505, 7, '090680'],
            [506, 12, '090681'],
            [507, 3, '090682'],
            [508, 2, '090684'],
            [509, 14, '090686'],
            [510, 1, '090688'],
            [511, 6, '090689'],
            [512, 3, '090690'],
            [513, 3, '090691'],
            [514, 3, '090696'],
            [515, 3, '090697'],
            [516, 3, '090698'],
            [517, 11, '090699'],
            [518, 4, '090700'],
            [519, 4, '090701'],
            [520, 7, '090702'],
            [521, 7, '090703'],
            [522, 7, '090704'],
            [523, 11, '090705'],
            [524, 5, '090706'],
            [525, 5, '090707'],
            [526, 12, '090708'],
            [527, 3, '090709'],
            [528, 3, '090710'],
            [529, 3, '090711'],
            [530, 2, '090712'],
            [531, 2, '090713'],
            [532, 1, '090714'],
            [533, 6, '090715'],
            [534, 6, '090716'],
            [535, 4, '090717'],
            [536, 4, '090718'],
            [537, 4, '090719'],
            [538, 4, '090720'],
            [539, 4, '090721'],
            [540, 4, '090722'],
            [541, 4, '090723'],
            [542, 4, '090724'],
            [543, 4, '090725'],
            [544, 4, '090726'],
            [545, 4, '090727'],
            [546, 4, '090728'],
            [547, 6, '090729'],
            [548, 7, '090730'],
            [549, 7, '090731'],
            [550, 5, '090732'],
            [551, 5, '090733'],
            [552, 3, '090734'],
            [553, 3, '090735'],
            [554, 3, '090736'],
            [555, 2, '090737'],
            [556, 6, '090738'],
            [557, 6, '090739'],
            [558, 4, '090740'],
            [559, 4, '090741'],
            [560, 4, '090742'],
            [561, 7, '090743'],
            [562, 6, '090744'],
            [563, 6, '090745'],
            [564, 6, '090746'],
            [565, 6, '090747'],
            [566, 3, '090748'],
            [567, 3, '090749'],
            [568, 2, '090750'],
            [569, 11, '090751'],
            [570, 5, '090752'],
            [571, 6, '090753'],
            [572, 2, '090754'],
            [573, 3, '090755'],
            [574, 5, '090756'],
            [575, 1, '090757'],
            [576, 12, '090758'],
            [577, 2, '090759'],
            [578, 7, '090760'],
            [579, 7, '090761'],
            [580, 1, '090762'],
            [581, 4, '090763'],
            [582, 11, '090764'],
            [583, 11, '090765'],
            [584, 5, '090766'],
            [585, 7, '090767'],
            [586, 7, '090768'],
            [587, 7, '090769'],
            [588, 4, '090770'],
            [589, 4, '090771'],
            [590, 4, '090772'],
            [591, 4, '090773'],
            [592, 12, '090774'],
            [593, 3, '090775'],
            [594, 3, '090776'],
            [595, 2, '090777'],
            [596, 1, '090778'],
            [597, 5, '090779'],
            [598, 4, '090780'],
            [599, 4, '090781'],
            [600, 4, '090782'],
            [601, 4, '090783'],
            [602, 4, '090784'],
            [603, 7, '090785'],
            [604, 7, '090786'],
            [605, 3, '090787'],
            [606, 3, '090788'],
            [607, 2, '090789'],
            [608, 4, '090790'],
            [609, 7, '090791'],
            [610, 6, '090792'],
            [611, 5, '090793'],
            [612, 4, '090794'],
            [613, 7, '090795'],
            [614, 3, '090796'],
            [615, 2, '090797'],
            [616, 6, '090798'],
            [617, 2, '090799'],
            [618, 4, '090800'],
            [619, 4, '090801'],
            [620, 4, '090802'],
            [621, 4, '090803'],
            [622, 13, '090804'],
            [623, 13, '090805'],
            [624, 2, '090806'],
            [625, 7, '090807'],
            [626, 10, '090808'],
            [627, 12, '090809'],
            [628, 10, '090810'],
            [629, 10, '090811'],
            [630, 3, '090812'],
            [631, 7, '090813'],
            [632, 3, '090814'],
            [633, 7, '090815'],
            [634, 3, '090816'],
            [635, 10, '090817'],
            [636, 7, '090818'],
            [637, 3, '090819'],
            [638, 3, '090820'],
            [639, 3, '090821'],
            [640, 6, '090822'],
            [641, 3, '090823'],
            [642, 2, '090824'],
            [643, 5, '090825'],
            [644, 12, '090826'],
            [645, 11, '090827'],
            [646, 25, '090828'],
            [647, 14, '090829'],
            [648, 13, '090830'],
            [649, 13, '090831'],
            [650, 7, '090832'],
            [651, 8, '090833'],
            [652, 10, '090834'],
            [653, 6, '090835'],
            [654, 26, '090836'],
            [655, 23, '090837'],
            [656, 3, '090838'],
            [657, 6, '090839'],
            [658, 6, '090840'],
            [659, 6, '090841'],
            [660, 7, '090842'],
            [661, 10, '090843'],
            [662, 27, '090844'],
            [663, 10, '090845'],
            [664, 10, '090846'],
            [665, 7, '090847'],
            [666, 3, '090848'],
            [667, 10, '090849'],
            [668, 10, '090850'],
            [669, 10, '090851'],
            [670, 3, '090852'],
            [671, 3, '090853'],
            [672, 7, '090854'],
            [673, 28, '090855'],
            [674, 10, '090856'],
            [675, 3, '090857'],
            [676, 4, '090858'],
            [677, 4, '090859'],
            [678, 2, '090860'],
            [679, 5, '090861'],
            [680, 6, '090862'],
            [681, 11, '090863'],
            [682, 4, '090864'],
            [683, 3, '090865'],
            [684, 6, '090866'],
            [685, 7, '090867'],
            [686, 4, '090868'],
            [687, 1, '090869'],
            [688, 4, '090870'],
            [689, 2, '090871'],
            [690, 4, '090872'],
            [691, 7, '090873'],
            [692, 4, '090874'],
            [693, 3, '090875'],
            [694, 6, '090876'],
            [695, 4, '090877'],
            [696, 5, '090878'],
            [697, 3, '090879'],
            [698, 4, '090880'],
            [699, 4, '090881'],
            [700, 3, '090882'],
            [701, 6, '090883'],
            [702, 4, '090884'],
            [703, 4, '090885'],
            [704, 7, '090886'],
            [705, 4, '090887'],
            [706, 3, '090888'],
            [707, 11, '090889'],
            [708, 11, '090890'],
            [709, 6, '090891'],
            [710, 5, '090892'],
            [711, 3, '090893'],
            [712, 4, '090894'],
            [713, 7, '090895'],
            [714, 12, '090896'],
            [715, 1, '090897'],
            [716, 3, '090898'],
            [717, 2, '090899'],
            [718, 4, '090900'],
            [719, 4, '090901'],
            [720, 7, '090902'],
            [721, 5, '090903'],
            [722, 3, '090904'],
            [723, 3, '090905'],
            [724, 2, '090906'],
            [725, 6, '090907'],
            [726, 11, '090908'],
            [727, 3, '090909'],
            [728, 10, '090910'],
            [729, 3, '090911'],
            [730, 7, '090912'],
            [731, 10, '090913'],
            [732, 10, '090914'],
            [733, 10, '090915'],
            [734, 3, '090916'],
            [735, 7, '090917'],
            [736, 7, '090918'],
            [737, 7, '090919'],
            [738, 10, '090920'],
            [739, 3, '090921'],
            [740, 7, '090922'],
            [741, 10, '090923'],
            [742, 10, '090924'],
            [743, 3, '090925'],
            [744, 7, '090926'],
            [745, 3, '090927'],
            [746, 3, '090928'],
            [747, 10, '090929'],
            [748, 13, '090930'],
            [749, 13, '090931'],
            [750, 13, '090932'],
            [751, 7, '090933'],
            [752, 7, '090934'],
            [753, 7, '090935'],
            [754, 13, '090936'],
            [755, 13, '090937'],
            [756, 13, '090938'],
            [757, 13, '090939'],
            [758, 6, '090940'],
            [759, 2, '090941'],
            [760, 5, '090942'],
            [761, 11, '090943'],
            [762, 12, '090944'],
            [763, 1, '090945'],
            [764, 2, '090946'],
            [765, 6, '090947'],
            [766, 6, '090948'],
            [767, 6, '090949'],
            [768, 2, '090950'],
            [769, 11, '090951'],
            [770, 11, '090952'],
            [771, 5, '090953'],
            [772, 3, '090954'],
            [773, 1, '090955'],
            [774, 6, '090956'],
            [775, 6, '090957'],
            [776, 6, '090958'],
            [777, 6, '090959'],
            [778, 6, '090960'],
            [779, 3, '090961'],
            [780, 3, '090962'],
            [781, 5, '090963'],
            [782, 28, '090964'],
            [783, 6, '090965'],
            [784, 7, '090966'],
            [785, 13, '090967'],
            [786, 10, '090968'],
            [787, 3, '090969'],
            [788, 3, '090970'],
            [789, 3, '090971'],
            [790, 6, '090972'],
            [791, 2, '090973'],
            [792, 5, '090974'],
            [793, 11, '090975'],
            [794, 12, '090976'],
            [795, 1, '090977'],
            [796, 14, '090978'],
            [797, 6, '090979'],
            [798, 10, '090980'],
            [799, 10, '090981'],
            [800, 10, '090982'],
            [801, 10, '090983'],
            [802, 10, '090984'],
            [803, 10, '090985'],
            [804, 3, '090986'],
            [805, 3, '090987'],
            [806, 3, '090988'],
            [807, 7, '090989'],
            [808, 7, '090990'],
            [809, 7, '090991'],
            [810, 7, '090992'],
            [811, 7, '090993'],
            [812, 7, '090994'],
            [813, 10, '090995'],
            [814, 10, '090996'],
            [815, 10, '090997'],
            [816, 3, '090998'],
            [817, 3, '090999'],
            [818, 3, '080140'],
            [819, 3, '080141'],
            [820, 3, '080142'],
            [821, 3, '080143'],
            [822, 3, '080144'],
            [823, 3, '080145'],
            [824, 3, '080146'],
            [825, 3, '080147'],
            [826, 3, '080148'],
            [827, 3, '080149'],
            [828, 3, '080150'],
            [829, 3, '080151'],
            [830, 3, '080152'],
            [831, 6, '080153'],
            [832, 6, '080154'],
            [833, 7, '080155'],
            [834, 7, '080156'],
            [835, 7, '080157'],
            [836, 7, '080158'],
            [837, 7, '080159'],
            [838, 7, '080160'],
            [839, 7, '080161'],
            [840, 7, '080162'],
            [841, 2, '080163'],
            [842, 2, '080164'],
            [843, 5, '080165'],
            [844, 5, '080166'],
            [845, 5, '080167'],
            [846, 5, '080168'],
            [847, 5, '080169'],
            [848, 6, '080170'],
            [849, 6, '080171'],
            [850, 6, '080172'],
            [851, 6, '080173'],
            [852, 6, '080174'],
            [853, 6, '080175'],
            [854, 6, '080176'],
            [855, 6, '080177'],
            [856, 6, '080178'],
            [857, 6, '080179'],
            [858, 5, '080180'],
            [859, 5, '080181'],
            [860, 5, '080182'],
            [861, 5, '080183'],
            [862, 5, '080184'],
            [863, 5, '080185'],
            [864, 11, '080186'],
            [865, 11, '080187'],
            [866, 11, '080188'],
            [867, 11, '080189'],
            [868, 2, '080190'],
            [869, 2, '080191'],
            [870, 2, '080192'],
            [871, 2, '080193'],
            [872, 2, '080194'],
            [873, 12, '080195'],
            [874, 12, '080196'],
            [875, 11, '080197'],
            [876, 11, '080198'],
            [877, 1, '080199'],
            [878, 3, '080240'],
            [879, 3, '080241'],
            [880, 3, '080242'],
            [881, 3, '080243'],
            [882, 3, '080244'],
            [883, 3, '080245'],
            [884, 3, '080246'],
            [885, 3, '080247'],
            [886, 3, '080248'],
            [887, 3, '080249'],
            [888, 3, '080250'],
            [889, 3, '080251'],
            [890, 3, '080252'],
            [891, 3, '080253'],
            [892, 3, '080254'],
            [893, 7, '080260'],
            [894, 7, '080261'],
            [895, 7, '080262'],
            [896, 7, '080263'],
            [897, 7, '080264'],
            [898, 7, '080265'],
            [899, 7, '080266'],
            [900, 6, '080269'],
            [901, 6, '080270'],
            [902, 6, '080271'],
            [903, 6, '080272'],
            [904, 6, '080273'],
            [905, 6, '080274'],
            [906, 6, '080275'],
            [907, 6, '080276'],
            [908, 6, '080277'],
            [909, 6, '080278'],
            [910, 6, '080279'],
            [911, 5, '080280'],
            [912, 5, '080281'],
            [913, 5, '080282'],
            [914, 5, '080283'],
            [915, 5, '080284'],
            [916, 1, '080285'],
            [917, 11, '080286'],
            [918, 11, '080287'],
            [919, 2, '080288'],
            [920, 2, '080289'],
            [921, 2, '080290'],
            [922, 2, '080291'],
            [923, 2, '080292'],
            [924, 2, '080293'],
            [925, 2, '080294'],
            [926, 12, '080295'],
            [927, 12, '080296'],
            [928, 2, '080297'],
            [929, 2, '080298'],
            [930, 2, '080299'],
            [931, 14, '080648'],
            [932, 14, '080649'],
            [933, 5, '080820'],
            [934, 5, '080821'],
            [935, 7, '080825'],
            [936, 3, '080830'],
            [937, 3, '080831'],
            [938, 6, '080835'],
            [939, 6, '080836'],
            [940, 6, '080837'],
            [941, 14, '080985'],
        ];

        foreach ($stations as $station) {
            Station::create([
                'id' => $station[0],
                'area_id' => $station[1],
                'prefix' => $station[2],
            ]);
        }
    }
}
