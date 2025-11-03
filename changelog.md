
## {{date}}
### {{version}}
- 补充漏更子包。

## 2025-11-03
### v1.1.0
- 最低支持PHP版本从8.0提升至8.0.2。
- 更新依赖包`illuminate/contracts`从8.83.x至9.52.x。

## 2025-11-02
### v1.0.2
- 修正主包的依赖包名称

### v1.0.1
- 修正url包的依赖包名称

### v1.0.0
- 采用单仓库（Monorepo）开发多个子包（sub-packages）的模式，尽可能多的参考、借鉴和遵循php-fig、laravel和symfony提供的接口来实现本库。
- 新增`Entity`实体属性包。
  - 支持不破坏`Attribute`原`__call`实现的方式下，扩展有前缀、无前缀方法。
- 新增`Url`工具包。
- 使用`vitepress`生成文档。
- 使用`symplify/monorepo-builder`处理单仓库相关事项。
