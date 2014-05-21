<?hh
namespace core;
use config\RoutingConfig;
use core\http\Request;
/**
 * Description of Routing
 *
 * @author uetiko
 */
class Routing {
    /**
     *
     * @var array
     */
    private array $rules;
    protected function __construct() {
        $this->rules = RoutingConfig::getRoutingRules();
    }
    
    protected function findRoutingRule(Request $request): array{
        foreach ($this->rules as $value) {
            if(in_array($request->getAttribute('PATH_INFO'), $value)){
                return $value;
            }
        }
    }
    
    protected function getDefaults(string $pattern): ?array{
        foreach ($this->rules as $value) {
            if(in_array($pattern, $value)){
                return $value['defaults'];
            }
        }
    }
}
