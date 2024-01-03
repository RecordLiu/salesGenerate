<?php

class generate
{
    /**
     * 姓名构造
     */
    public function funcGenerateName()
    {
        $firstNames = '赵,钱,孙,李,周,吴,郑,王,冯,陈,褚,卫,蒋,沈,韩,杨,朱,秦,尤,许,何,吕,施,张,孔,曹,严,华,金,魏,陶,姜,戚,谢,邹,喻,柏,水,窦,章,云,苏,潘,葛,奚,范,彭,郎,鲁,韦,昌,马,苗,凤,花,方,俞,任,袁,柳,酆,鲍,史,唐,费,廉,岑,薛,雷,贺,倪,汤,滕,殷,罗,毕,郝,邬,安,常,乐,于,时,傅,皮,卞,齐,康,伍,余,元,卜,顾,孟,平,黄,和,穆,萧,尹,姚,邵,湛,汪,祁,毛,禹,狄,米,贝,明,臧,计,伏,成,戴,谈,宋,茅,庞,熊,纪,舒,屈,项,祝,董,梁,杜,阮,蓝,闵,席,季,麻,强,贾,路,娄,危,江,童,颜,郭,梅,盛,林,刁,钟,徐,邱,骆,高,夏,蔡,田,樊,胡,凌,霍,虞,万,支,柯,昝,管,卢,莫,经,房,裘,缪,干,解,应,宗,丁,宣,贲,邓,郁,单,杭,洪,包,诸,左,石,崔,吉,钮,龚,程,邢,滑,裴,陆,荣,翁,荀,惠,甄,家,封,芮,羿,储,靳,汲,邴,糜,松,井,段,富,巫,乌,焦,巴,弓,牧,隗,山,谷,车,侯,蓬,全,班,仰,秋,仲,伊,宁,仇,栾,暴,甘,,祖,武,符,刘,景,詹,束,龙,叶,幸,司,韶,郜,黎,薄,印,宿,白';
        $firstNamesArr = explode(',', $firstNames);
        $maleLastName = '男|阳,男|洋,男|浩宇,男|浩然,男|宇轩,男|子轩,男|宇航,男|皓轩,男|子豪,男|浩轩,男|俊杰,男|子涵,男|涛,男|浩,男|杰,男|鑫,男|俊杰,男|磊,男|帅,男|宇,男|浩然,男|鹏,男|伟,男|超,男|涛,男|杰,男|鹏,男|磊,男|强,男|浩,男|鑫,男|帅,男|伟,男|磊,男|勇,男|涛,男|超,男|强,男|鹏,男|军,男|波,男|杰';
        $femalLastName = '女|欣怡,女|梓涵,女|诗涵,女|梓宣,女|子涵,女|紫涵,女|佳怡,女|雨涵,女|雨欣,女|婷,女|欣怡,女|婷婷,女|静,女|悦,女|敏,女|佳怡,女|雪,女|颖,女|雨欣,女|静,女|婷,女|敏,女|婷婷,女|丹,女|雪,女|丽,女|倩,女|艳,女|娟';
        $maleLastNameArr = array_unique(explode(',', $maleLastName));
        $femaleLastNameArr = array_unique(explode(',', $femalLastName));
        $lastNameArr = array_merge($maleLastNameArr, $femaleLastNameArr);

        $areaArr = [
            '北京市', '上海市', '广州市', '深圳市', '杭州市', '武汉市', '西安市', '南京市', '成都市'
        ];
        $zhiyeArr = ['个体户', '公司职员', '教师', '自由职业'];

        $row = "序号,客户代码,客户姓名,城市,性别,职业,出生年份\n";
        file_put_contents('kehu.csv', $row, FILE_APPEND);

        $ord = 0;
        foreach ($firstNamesArr as $v) {
            $nameRands = $test = array_rand($lastNameArr, 5);
            foreach ($nameRands as $index) {
                $ord += 1;
                $one = $lastNameArr[$index];
                $tmp = explode("|", $one);
                $sex = $tmp[0];
                $name = $v . $tmp[1];
                $kfbm = 'kh' . sprintf("%04d", $ord);
                $age = rand(1980, 2000);
                $zhiye = $zhiyeArr[array_rand($zhiyeArr)];
                $diqu = $areaArr[array_rand($areaArr)];
                $row = sprintf("%d,%s,%s,%s,%s,%s,%d\n", $ord, $kfbm, $name, $diqu, $sex, $zhiye, $age);
                file_put_contents('kehu.csv', $row, FILE_APPEND);
                echo $row;
            }
        }
    }

    /**
     * 销售数据构造
     */
    public function funcGenerateSales()
    {
        $customers = $this->_getCustomers();
        $products = $this->_getProducts();
        $time = strtotime('2021-06-01');
        $orderDates = [];
        while ($time <= strtotime('2023-12-31')) {
            $orderDates[] = date("Y-m-d", $time);
            $time += 86400;
        }
        file_put_contents("orders.csv", "序号,订单号,订单日期,客户编码,产品编码,购买数量,折扣,销售额,利润\n", FILE_APPEND);
        $id = 1;
        foreach ($orderDates as $v) {
            $orderNums = rand(1, 100);
            for ($i = 0; $i < $orderNums; $i++) {
                $orderIds = sprintf('xs%s%06d', date('Ymd', strtotime($v)), $id);
                $customer = $customers[array_rand($customers)];
                $product = $products[array_rand($products)];
                $buyNums = rand(1, 10);
                $discounts = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0.8, 0.7, 0.9, 0.6, 0.5];
                $discount = $discounts[array_rand($discounts)];
                $sale = intval($buyNums * $product['price'] * sprintf("%.1f", $discount));
                $profit = $sale - $product['origin_price'] * $buyNums;
                $order = [
                    $id,
                    $orderIds,
                    $v,
                    $customer['customer_key'],
                    $product['product_key'],
                    $buyNums,
                    sprintf("%.1f", $discount),
                    $sale,
                    $profit,
                ];
                $order = implode(',', $order) . "\n";
                echo $order;
                file_put_contents("orders.csv", $order, FILE_APPEND);
                $id++;
            }
        }
    }

    /**
     * @return array
     */
    private function _getCustomers()
    {
        $filename = 'kehu.csv';
        $file = fopen($filename, 'r');
        $row = 0;
        $customers = [];
        if ($file) {
            while (($line = fgets($file)) !== false) {
                if ($row == 0) {
                    $row++;
                    continue;
                }
                $line = trim($line, "\n");
                $line = explode(',', $line);
                $customers[] = [
                    'id' => intval($line[0]),
                    'customer_key' => $line[1],
                    'name' => $line[2],
                    'city' => $line[3],
                    'sex' => $line[4],
                    'job' => $line[5],
                    'birth' => intval($line[6]),
                ];
                $row++;
            }
            fclose($file);
        } else {
            echo "无法打开文件。";
        }
        return $customers;
    }

    /**
     * @return array
     */
    private function _getProducts()
    {
        $filename = 'product.csv';
        $file = fopen($filename, 'r');
        $row = 0;
        $products = [];
        if ($file) {
            while (($line = fgets($file)) !== false) {
                if ($row == 0) {
                    $row++;
                    continue;
                }
                $line = trim($line, "\n");
                $line = explode(',', $line);
                $products[] = [
                    'id' => intval($line[0]),
                    'product_key' => $line[1],
                    'category_key' => $line[2],
                    'product_name' => $line[3],
                    'origin_price' => intval($line[4]),
                    'price' => intval($line[5]),
                ];
                $row++;
            }
            fclose($file);
        } else {
            echo "无法打开文件。";
        }
        return $products;
    }
}